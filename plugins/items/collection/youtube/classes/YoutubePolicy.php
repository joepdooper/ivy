<?php

namespace Items\Collection\Youtube;

use Ivy\Model\User;

class YoutubePolicy
{
    public static function create(Youtube $youtube): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Youtube $youtube): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(Youtube $youtube): bool
    {
        return User::canEditAsAdmin();
    }
}