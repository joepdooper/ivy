<?php

namespace NextcloudApi;

use Ivy\User\Domain\Entity\User;

class UserObserver
{
    public function created(User $user): void
    {
        // New user
    }
    public function saved(User $user): void
    {
        d($user);die;
    }

    public function updated(User $user): void
    {
        // Existing user updated
    }

     public function deleted(User $user): void
    {
        // User deleted
    }
}