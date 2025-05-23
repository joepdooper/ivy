<?php

namespace Items\Collection\Image;

use Ivy\Model\Profile;
use Ivy\Path;
use Ivy\View\LatteView;

class ImageTemplate
{
    public function render($item): void
    {
        $image = (new Image)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();
        LatteView::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'image' => $image,
            'author' => $author
        ]);
    }
}
