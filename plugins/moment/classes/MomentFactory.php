<?php

namespace Moment;

use Items\Item;
use Ivy\Core\Language;

class MomentFactory
{
    public function defaults(): array
    {
        $titles = Language::translate('moment.moment.factory.titles');

        return [
            'title' => $titles[array_rand($titles)],
            'item' => Item::class,
            'token' => null,
        ];
    }
}