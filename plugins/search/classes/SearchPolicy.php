<?php

namespace Search;

use Ivy\Model\User;

class SearchPolicy
{
    public static function post(Search $search): bool
    {
        return User::canEditAsEditor();
    }

    public static function index(Search $search): bool
    {
        return User::canEditAsEditor();
    }
}
