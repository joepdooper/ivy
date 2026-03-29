<?php

namespace Moment\Collection\MomentPeople;

use Moment\Moment;

class MomentPeopleFactory
{
    public function defaults(): array
    {
        return [
            'moment_id' => Moment::factory(),
            'people_id' => People::factory(),
            'token' => null,
        ];
    }
}
