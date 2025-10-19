<?php

namespace Moment\Collection\MomentPeople;

use Carbon\Carbon;
use Moment\Moment;

class MomentPeopleFactory
{
    public function defaults(): array
    {
        return [
            'moment_id' => Moment::factory(),
            'people_id' => 1,
            'token' => null,
        ];
    }
}