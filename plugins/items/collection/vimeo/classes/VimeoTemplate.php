<?php

namespace Items\Collection\Vimeo;

use Ivy\Model\Profile;
use Ivy\Path;
use Ivy\View\View;

class VimeoTemplate
{
    public function render($item): void
    {
        $vimeo = (new Vimeo)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();
        View::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'vimeo' => $vimeo,
            'author' => $author
        ]);
    }
}
