<?php

namespace Moments\Collection\MomentDateTime;

use Carbon\Carbon;
use Moments\Moment;

class MomentDateTimeFactory
{
    public function defaults(): array
    {
        return [
            'moment_id' => Moment::factory(),
            'start_date' => Carbon::now()->format('Y-m-d'),
            'end_date' => null,
            'start_time' => null,
            'end_time' => null,
            'token' => null,
        ];
    }
}
