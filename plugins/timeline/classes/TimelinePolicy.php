<?php

namespace Timeline;

use Ivy\Model\User;

class TimelinePolicy
{
    public static function create(Timeline $timeline): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Timeline $timeline): bool
    {
        return User::canEditAsAdmin();
    }

    public static function delete(Timeline $timeline): bool
    {
        return User::canEditAsAdmin();
    }
}