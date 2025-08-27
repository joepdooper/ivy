<?php

namespace Items\Collection\Text;

use Ivy\Model\User;

class TextPolicy
{
    public static function create(Text $text): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Text $text): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(Text $text): bool
    {
        return User::canEditAsAdmin();
    }
}