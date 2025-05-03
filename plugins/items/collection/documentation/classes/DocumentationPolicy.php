<?php

namespace Items\Collection\Documentation;

use Items\Item;
use Ivy\Model\User;

class DocumentationPolicy
{
    public static function create(Documentation $documentation): bool
    {
        return User::canEditAsAdmin();
    }

    public static function read(Documentation $documentation, Item $item): bool
    {
        if(User::getAuth()->isLoggedIn() || $item->published){
            return true;
        } else {
            return false;
        }
    }

    public static function update(Documentation $documentation): bool
    {
        return User::canEditAsEditor();
    }

    public static function delete(Documentation $documentation): bool
    {
        return User::canEditAsAdmin();
    }
}