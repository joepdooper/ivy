<?php

namespace Contacts;

use Carbon\Carbon;
use Items\Item;
use Ivy\Core\Language;
use Ivy\Model\Profile;

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
