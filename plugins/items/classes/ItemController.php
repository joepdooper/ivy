<?php

namespace Items;

use Ivy\Abstract\Controller;
use Ivy\Manager\DatabaseManager;
use Ivy\Path;
use Ivy\View\LatteView;

class ItemController extends Controller
{
    protected Item $item;
    protected ?string $slug = null;

    public function post(): void
    {
        $this->authorize('post', Item::class);

        $itemTemplate = (new ItemTemplate)->where('id', $this->request->get('item_template_id'))->fetchOne();

        $this->redirect($itemTemplate->route . '/insert/' . $this->request->get('item_template_id'));
    }

    public function index(): void
    {
        $this->authorize('index', Item::class);

        $items = (new Item)->where('parent_id')->sortBy(['sort', 'date', 'id'])->fetchAll();
        LatteView::set(Path::get('PLUGIN_PATH') . 'items/template/index.latte', ['items' => $items]);
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
}