<?php

namespace Items\Collection\Text;

use Ivy\Model\Profile;
use Ivy\Path;
use Ivy\View\LatteView;

class TextTemplate
{
    public function render($item): void
    {
        $text = (new Text)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();
        LatteView::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', ['item' => $item, 'text' => $text, 'author' => $author]);
    }
}
