<?php

namespace Contacts;

use Carbon\Carbon;
use Ivy\User\Domain\Entity\Profile;

class ContactFactory
{
    public function defaults(): array
    {
        return [
            'name' => 'Ivy',
            'email' => 'user@test.de',
            'birthday' => Carbon::now()->subYears(30),
            'profile_id' => Profile::factory(),
        ];
    }
}
