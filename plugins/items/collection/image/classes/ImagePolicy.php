<?php

namespace Items\Collection\Image;

use Ivy\Model\User;

class ImagePolicy
{
    public static function create(Image $image): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Image $image): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(Image $image): bool
    {
        return User::canEditAsAdmin();
    }
}