<?php

namespace Moment;

use Carbon\Carbon;

class MomentFactory
{
    public function defaults(): array
    {
        $titles = [
            'Yet another moment defined!',
            'Yet another moment lived!',
            'Yet another moment registered!'
        ];

        return [
            'title' => $titles[array_rand($titles)],
            'token' => null,
        ];
    }
}