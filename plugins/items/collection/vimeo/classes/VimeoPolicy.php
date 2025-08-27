<?php

namespace Items\Collection\Vimeo;

use Ivy\Model\User;

class VimeoPolicy
{
    public static function create(Vimeo $vimeo): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Vimeo $vimeo): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(Vimeo $vimeo): bool
    {
        return User::canEditAsAdmin();
    }
}