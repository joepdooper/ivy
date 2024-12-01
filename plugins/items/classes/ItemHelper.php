<?php

namespace Items;

use Ivy\DB;

class ItemHelper
{
    public static function getPluginControllerClasses($items): object|array
    {
        foreach ($items as $key => $item) {
            if ($item->published || $item->author) {
                $pluginNamespace = $item->namespace;
                $controllerClass = "$pluginNamespace\\{$pluginNamespace}Controller";
                if (class_exists($controllerClass)) {
                    $item->controller = new $controllerClass();
                }
            } else {
                unset($items[$key]);
            }
        }

        return $items;
    }

    public static function createSlug($string): string
    {
        $string = self::slugify($string);
        $count = 1;

        while (self::checkSlug($string)) {
            $string = preg_replace('/-\d+$/', '', $string);
            $string = $string . '-' . $count;
            $count++;
        }

        return $string;
    }

    private static function checkSlug($slug): bool
    {
        $result = DB::$connection->selectRow("SELECT COUNT(*) AS count FROM items WHERE slug = :slug", ['slug' => $slug]);

        return $result['count'] > 0;
    }

    public static function slugify($string): string
    {
        $string = strtolower($string);
        $string = str_replace(' ', '-', $string);
        $string = preg_replace('/[^a-z0-9\-]/', '', $string);
        $string = preg_replace('/-+/', '-', $string);
        return trim($string, '-');
    }
}
