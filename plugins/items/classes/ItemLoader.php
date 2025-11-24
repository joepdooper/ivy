<?php

namespace Items;

use Ivy\Model\Profile;

class ItemLoader
{
    public static function attach(array &$items, array $load = []): void
    {
        if (empty($items)) return;

        $itemsById = [];
        foreach ($items as $item) {
            $itemsById[$item->id] = $item;
        }

        $itemIds = array_keys($itemsById);
        $registry = ItemRegistry::all();

        $pluginsByItemId = [];

        if (!empty($load['plugins'])) {
            foreach ($registry as $modelClass) {
                $rows = (new $modelClass())
                    ->whereIn('item_id', $itemIds)
                    ->fetchAll();

                foreach ($rows as $plugin) {
                    $pluginsByItemId[$plugin->item_id] = $plugin;
                }
            }
        }

        $authorsById = [];

        if (!empty($load['authors'])) {
            $userIds = array_unique(array_map(fn($i) => $i->user_id, $items));

            if (!empty($userIds)) {
                $authors = Profile::query()
                    ->whereIn('id', $userIds)
                    ->fetchAll();

                foreach ($authors as $author) {
                    $authorsById[$author->id] = $author;
                }
            }
        }

        foreach ($items as $item) {
            if (!empty($load['plugins'])) {
                $plugin = $pluginsByItemId[$item->id] ?? null;
                if ($plugin) {
                    $plugin->item = $item;
                }
                $item->setRelation('plugin', $plugin);
            }

            if (!empty($load['authors'])) {
                $author = $authorsById[$item->user_id] ?? null;
                $item->setRelation('author', $author);
            }
        }
    }
}