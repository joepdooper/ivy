<?php

namespace Moment;

use Ivy\Core\Language;

class MomentFactory
{
    public function defaults(): array
    {
        $titles = Language::translate('moment.moment.factory.titles');

        return [
            'title' => $titles[array_rand($titles)],
            'token' => null,
        ];
    }
}