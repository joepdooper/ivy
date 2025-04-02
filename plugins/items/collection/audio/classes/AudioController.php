<?php

namespace Items\Collections\Audio;

use Ivy\Controller;
use Ivy\Profile;
use Ivy\Template;

class AudioController extends Controller
{
    private Audio $audio;

    public function __construct()
    {
        $this->audio = new Audio;
    }

    public function item($item): void
    {
        if ($item->published || $item->author) {
            $audio = $this->audio->where('id', $item->table_id)->fetchOne();
            $author = (new Profile)->where('id', $item->user_id)->fetchOne();
            $author->date = $item->date;
            Template::render(_PLUGIN_PATH . $item->plugin_url . '/template/item.latte', ['item' => $item, 'audio' => $audio, 'author' => $author]);
        }
    }
}
