<?php

namespace Items\Collection\Audio;

use Ivy\Model\Profile;
use Ivy\Path;
use Ivy\View\View;

class AudioTemplate
{
    public function render($item): void
    {
        $audio = (new Audio)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();
        View::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'audio' => $audio,
            'author' => $author
        ]);
    }
}
