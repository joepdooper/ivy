<?php

namespace Moment\Collection\MomentLocation;

use Ivy\Model\User;

class MomentLocationPolicy
{
    public static function create(MomentLocation $momentLocation): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(MomentLocation $momentLocation): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(MomentLocation $momentLocation): bool
    {
        return User::canEditAsAdmin();
    }
}