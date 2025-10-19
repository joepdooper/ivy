<?php

namespace Moment;

use Ivy\Model\User;

class MomentPolicy
{
    public static function create(Moment $moment): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Moment $moment): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(Moment $moment): bool
    {
        return User::canEditAsAdmin();
    }
}