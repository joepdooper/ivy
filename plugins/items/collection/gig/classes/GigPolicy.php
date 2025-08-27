<?php

namespace Items\Collection\Gig;

use Items\Item;
use Ivy\Model\User;

class GigPolicy
{
    public static function create(Gig $gig): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Gig $gig): bool
    {
        return User::canEditAsEditor();
    }

    public static function delete(Gig $gig): bool
    {
        return User::canEditAsAdmin();
    }
}