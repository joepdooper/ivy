<?php

namespace Items;

use Ivy\Abstract\Controller;
use Ivy\Path;
use Ivy\View\LatteView;

class ItemController extends Controller
{
    protected Item $item;
    protected ?string $slug = null;

    public function insert($id, $template_route = null, $identifier = null): void
    {
        try {
            $parent_id = isset($identifier) ? (new Item)->where('slug', $identifier)->fetchOne()->id : null;
            $slug = ItemHelper::createSlug($this->slug);
            $this->item->insert(['template' => $id, 'parent' => $parent_id, 'slug' => $slug]);
            $this->flashBag->add('success', 'Item inserted');
            $this->redirect(isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($slug) : "");
        } catch (\Exception $e) {
            $this->flashBag->add('error', $e->getMessage());
            $this->redirect();
        }
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        try {
            $slug = ItemHelper::createSlug($this->slug);
            $this->item->update(['slug' => $slug]);
            $this->flashBag->add('success', 'Item updated');
            $this->redirect(isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($slug) : "");
        } catch (\Exception $e) {
            $this->flashBag->add('error', $e->getMessage());
            $this->redirect();
        }
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        try {
            $this->item->where('id', $id)->getRow();
            $this->item->delete();
            $this->flashBag->add('success', 'Item deleted');
            $this->redirect(isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($slug) : "");
        } catch (\Exception $e) {
            $this->flashBag->add('error', $e->getMessage());
            $this->redirect();
        }
    }

    public function post(): void
    {
        $this->authorize('post', Item::class);
        $itemTemplate = (new ItemTemplate)->where('id', $this->request->get('item_template_id'))->fetchOne();
        $this->redirect($itemTemplate->route . DIRECTORY_SEPARATOR . 'insert' . DIRECTORY_SEPARATOR . $this->request->get('item_template_id'));
    }

    public function index(): void
    {
        $this->authorize('index', Item::class);
        $items = (new Item)->where('parent_id')->sortBy(['sort', 'date', 'id'])->fetchAll();
        $item_templates = (new ItemTemplate)
            ->select(['id', 'name', 'plugin.active'])
            ->addJoin('plugin', 'plugin_url', '=', 'url')
            ->fetchAll();
        LatteView::set(Path::get('PLUGIN_PATH') . 'items/template/item_index.latte', ['items' => $items, 'item_templates' => $item_templates]);
    }
}