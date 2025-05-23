<?php

namespace Items;

use Ivy\Manager\DatabaseManager;

class ItemHelper
{
    public static function getParentId($request): ?int
    {
        $segments = explode('/', self::getRefererPath($request));

        if (count($segments) !== 2) {
            return null;
        }

        return (new Item)
            ->where('item_template.table', $segments[0])
            ->where('slug', $segments[1])
            ->fetchOne()?->getId();
    }

    public static function getRedirect($request): string
    {
        $trimmedPath = self::getRefererPath($request);
        if(!empty($trimmedPath)){
            if(!(new Item)->where('slug', basename($trimmedPath))->fetchOne()){
                $item = (new Item)->where('id', basename($request->getPathInfo()))->fetchOne();
                $trimmedPath = $item->route . '/' . $item->slug;
            }
        }
        return $trimmedPath;
    }

    private static function getRefererPath($request): ?string
    {
        $referer = $request->headers->get('referer');
        $basePath = $request->getBasePath();
        $path = parse_url($referer, PHP_URL_PATH);

        if (!$path || !$basePath || !str_starts_with($path, $basePath)) {
            return null;
        }

        return ltrim(substr($path, strlen($basePath)), '/');
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
        $result = DatabaseManager::connection()->selectRow("SELECT COUNT(*) AS count FROM items WHERE slug = :slug", ['slug' => $slug]);

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
