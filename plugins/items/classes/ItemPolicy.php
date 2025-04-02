<?php

namespace Items;

use Ivy\Model\User;

abstract class ItemPolicy
{
    public static function post(Item $item): bool
    {
        return User::canEditAsEditor();
    }

    public static function index(Item $item): bool
    {
        return User::canEditAsEditor();
    }
}