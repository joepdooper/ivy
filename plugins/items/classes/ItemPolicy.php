<?php

namespace Items;

use Ivy\Model\User;

class ItemPolicy
{
    public static function index(Item $item): bool
    {
        return true;
    }

    public static function add(Item $item): bool
    {
        return User::canEditAsEditor();
    }

    public static function insert(Item $item): bool
    {
        return User::canEditAsEditor();
    }

    public static function view(Item $item): bool
    {
        if (User::canEditAsSuperAdmin() || ($item->author->user_id === User::getAuth()->getUserId()) || $item->publish) {
            return true;
        } else {
            return false;
        }
    }

    public static function update(Item $item): bool
    {
        return User::canEditAsEditor();
    }
}
