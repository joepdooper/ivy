<?php

namespace Items\Collection\Audio;

use Ivy\Model\Profile;
use Ivy\Core\Path;
use Ivy\Model\User;
use Ivy\View\View;

class AudioTemplate
{
    public function render($item): void
    {
        if (!(User::getAuth()->isLoggedIn() || $item->publish)) {
            return;
        }

        $audio = (new Audio)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();

        View::render(Path::get('PLUGINS_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'audio' => $audio,
            'author' => $author
        ]);
    }
}
