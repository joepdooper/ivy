<?php

namespace Items;

use Ivy\Abstract\Controller;
use Ivy\Manager\DatabaseManager;
use Ivy\Core\Path;
use Ivy\Model\User;
use Ivy\View\View;
use Tags\Tag;

class ItemController extends Controller
{
    protected Item $item;
    protected ?string $slug = null;

    public function __construct()
    {
        parent::__construct();
        $this->item = new Item;
    }

    public function post(): void
    {
        $this->item->policy('post');

        if(!$this->request->get('item_template_id')) {
            $this->flashBag->add('warning', 'No template was selected');
            $this->redirect(ItemHelper::getRedirect($this->request));
        } else {
            $itemTemplate = (new ItemTemplate)->where('id', $this->request->get('item_template_id'))->fetchOne();
            $this->redirect($itemTemplate->route . '/insert/' . $this->request->get('item_template_id'));
        }
    }

    public function index(): void
    {
        $this->item->policy('index');

        $items = Item::query()
            ->with(['plugins', 'authors'])
            ->filter([
                'user_id' => User::getAuth()->getUserId(),
            ])
            ->when($this->request->request->has('search'), function ($query) {
                $terms = str_getcsv($this->request->request->get('search'), ' ', "'");
                foreach ($terms as $term) {
                    $query->orFilter($term);
                }
            })
            ->sortBy('date')
            ->fetchAll();

        $tags = Tag::query()->fetchAll();

        View::set(Path::get('PLUGINS_FOLDER') . 'items/template/index.latte', [
            'items' => $items,
            'tags' => $tags
        ]);
    }

    public function save($id): void
    {
        if($this->request->request->has('delete')){
            $this->delete($id);
        } else {
            $this->update($id);
        }
    }

    public function update($id): void
    {
        $item = $this->item->where('id', $id)->fetchOne();
        $item->updateFromRequest($this->request->request->all());

        $this->redirect(ItemHelper::getRedirect($this->request, $item));
    }

    public function delete($id): void
    {
        $item = $this->item->with(['plugins'])->where('id', $id)->fetchOne();

        if (method_exists($item->plugin, 'policy') && method_exists($item->plugin, 'delete')) {
            if($item->plugin->policy('delete')){
                $message = $item->plugin->getSlug() ? $item->plugin->{$item->plugin->getSlug()} : $item->id;
                $item->plugin->delete();
                $this->flashBag->add('success', "$message successfully deleted");
            }
        } else {
            $item->delete();
        }

        $this->redirect(ItemHelper::getRedirect($this->request, $item));
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
                } catch (\Exception $e) {
                    error_log("Failed to delete from child table in item plugin: " . $e->getMessage());
                }
                try {
                    DatabaseManager::connection()->delete(
                        'items',
                        [
                            'id' => $child->id
                        ]
                    );
                } catch (\Exception $e) {
                    error_log("Failed to delete items child in item plugin: " . $e->getMessage());
                }
            }
        }
    }

    public function sort(): void
    {
        $this->item->policy('update');

        $_POST = json_decode(file_get_contents("php://input"), true);

        foreach ($_POST['data'] as $key => $value) {
            $this->item->where('id', $value)->populate(['sort' => $key])->update();
        }

        $this->redirect();
    }
}