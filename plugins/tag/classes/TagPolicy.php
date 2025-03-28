<?php

namespace Tag;

use Ivy\Model\User;

class TagPolicy
{
    public static function post(Tag $tag): bool
    {
        return User::canEditAsEditor();
    }

    public static function index(Tag $tag): bool
    {
        return User::canEditAsEditor();
    }
}
