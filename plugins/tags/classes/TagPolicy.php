<?php

namespace Tags;

use Ivy\Model\User;

class TagPolicy
{
    public static function index(Tag $tag): bool
    {
        return User::canEditAsEditor();
    }
    public static function sync(Tag $tag): bool
    {
        return User::canEditAsEditor();
    }
}
