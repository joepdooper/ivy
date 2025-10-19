<?php

namespace Moment\Collection\MomentPeople;

use Ivy\Model\User;

class MomentPeoplePolicy
{
    public static function create(MomentPeople $momentPeople): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(MomentPeople $momentPeople): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(MomentPeople $momentPeople): bool
    {
        return User::canEditAsAdmin();
    }
}