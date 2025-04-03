<?php

namespace Items;

use Delight\Db\Throwable\EmptyWhereClauseError;
use Exception;
use Ivy\Abstract\Controller;
use Ivy\Manager\DatabaseManager;
use Ivy\Path;
use Ivy\View\LatteView;

class ItemController extends Controller
{
    protected Item $item;
    protected ?string $slug = null;

    public function insert($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('post', Item::class);

        try {
            $parent_id = isset($identifier) ? (new Item)->where('slug', $identifier)->fetchOne()->id : null;
            $slug = ItemHelper::createSlug($this->slug);
            $this->item->insert(['template' => $id, 'parent' => $parent_id, 'slug' => $slug]);
            $this->flashBag->add('success', 'Item inserted');
            $this->redirect(isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($slug) : "");
        } catch (Exception $e) {
            $this->flashBag->add('error', $e->getMessage());
            $this->redirect();
        }
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        try {
            $this->item->where('id', $id)->fetchOne();
            d($this->item);
            // $slug = ItemHelper::createSlug($this->slug);
            // $this->item->populate(['slug' => $slug])->update();
            $this->flashBag->add('success', 'Item updated');
            $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($slug) : '');
        } catch (Exception $e) {
            $this->flashBag->add('error', $e->getMessage());
            $this->redirect();
        }
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        try {
            $this->item->where('id', $id)->fetchOne();
            $this->item->delete();
            $this->deleteChildren();
            $this->flashBag->add('success', 'Item deleted');
            $this->redirect(isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($this->item->slug) : "");
        } catch (Exception $e) {
            $this->flashBag->add('error', $e->getMessage());
            $this->redirect();
        }
    }

    public function deleteChildren(): void
    {
        $children = (new Item())->where('parent',  $this->item->id)->fetchAll();
        if (!empty($children)) {
            foreach ($children as $child) {
                try {
                    DatabaseManager::connection()->delete(
                        $child->table,
                        [
                            'id' => $child->table_id
                        ]
                    );
                } catch (Exception $e) {
                    error_log("Failed to delete from child table in item plugin: " . $e->getMessage());
                }
                try {
                    DatabaseManager::connection()->delete(
                        'items',
                        [
                            'id' => $child->id
                        ]
                    );
                } catch (Exception $e) {
                    error_log("Failed to delete items child in item plugin: " . $e->getMessage());
                }
            }
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