<?php

namespace Items\Collection\Youtube;

use Ivy\Model\Profile;
use Ivy\Path;
use Ivy\View\LatteView;

class YoutubeTemplate
{
    public function render($item): void
    {
        $youtube = (new Youtube)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();
        LatteView::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'youtube' => $youtube,
            'author' => $author
        ]);
    }
}
