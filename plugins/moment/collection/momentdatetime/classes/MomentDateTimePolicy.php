<?php

namespace Moment\Collection\MomentDateTime;

use Ivy\Model\User;

class MomentDateTimePolicy
{
    public static function create(MomentDateTime $momentDateTime): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(MomentDateTime $momentDateTime): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(MomentDateTime $momentDateTime): bool
    {
        return User::canEditAsAdmin();
    }
}