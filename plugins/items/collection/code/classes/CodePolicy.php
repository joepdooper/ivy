<?php

namespace Items\Collection\Code;

use Ivy\Model\User;

class CodePolicy
{
    public static function create(Code $code): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Code $code): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(Code $code): bool
    {
        return User::canEditAsAdmin();
    }
}