<?php

namespace Items;

use Ivy\Model\User;

class ItemSearch
{
    public static function search(array $terms): array
    {
        $results = [];

        $registry = ItemRegistry::all();

        foreach ($registry as $pluginClass) {
            $plugin = new $pluginClass();

            if (!property_exists($plugin, 'searchableColumns') || empty($plugin->searchableColumns)) {
                continue; // skip if plugin has no searchable columns
            }

            $query = $plugin::query();

            foreach ($terms as $term) {
                $termQuery = [];
                foreach ($plugin->searchableColumns as $col) {
                    $termQuery[] = [$col => ['like' => "%$term%"]];
                }

                $query->orFilter($termQuery);
            }

            $items = $query->fetchAll();
            if (!empty($items)) {
                $results[$pluginClass] = $items;
            }
        }

        return $results;
    }
}