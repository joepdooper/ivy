<?php

namespace Items\Collection\Moment;

use Carbon\Carbon;

class MomentFactory
{
    public function defaults(): array
    {
        return [
            'title' => array_rand([
                'Yet another moment to define!',
                'Yet another moment lived!',
                'Yet another moment gathered!'
            ]),
            'start_date' => Carbon::now()->format('Y-m-d'),
            'end_date' => null,
            'start_time' => null,
            'end_time' => null,
            'token' => null,
        ];
    }
}