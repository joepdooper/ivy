<?php

namespace Moments\Collection\MomentPeople;

use Contacts\Contact;
use Moments\Moment;

class MomentPeopleFactory
{
    public function defaults(): array
    {
        return [
            'moment_id' => Moment::factory(),
            'people_id' => Contact::factory(),
            'token' => null,
        ];
    }
}
