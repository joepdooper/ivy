<?php

namespace Items;

class ItemRegistry
{
    protected static array $itemModels = [];

    public static function register(string $type, string $model): void
    {
        static::$itemModels[$type] = $model;
    }

    public static function all(): array
    {
        return self::$itemModels;
    }

    public static function get(string $type): ?string
    {
        return self::$itemModels[$type] ?? null;
    }
}
