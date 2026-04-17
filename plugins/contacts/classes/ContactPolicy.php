<?php

namespace Contacts;

use Ivy\Model\Setting;
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

    public static function save(Contact $contact): bool
    {
        return User::canEditAsAdmin();
    }

    public static function add(Contact $contact): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Contact $contact): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(Contact $contact): bool
    {
        if (! $contact->profile_id && User::canEditAsAdmin()) {
            return true;
        }

        return false;
    }
}
