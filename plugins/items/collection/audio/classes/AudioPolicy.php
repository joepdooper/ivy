<?php

namespace Items\Collection\Audio;

use Ivy\Model\User;

class AudioPolicy
{
    public static function create(Audio $audio): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Audio $audio): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(Audio $audio): bool
    {
        return User::canEditAsAdmin();
    }
}