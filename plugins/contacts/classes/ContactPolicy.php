<?php

namespace Contacts;

use Ivy\Model\User;

class ContactPolicy
{
    public static function index(Contact $contact): bool
    {
        return User::canEditAsEditor();
    }

    public static function sync(Contact $contact): bool
    {
        return User::canEditAsEditor();
    }
}
