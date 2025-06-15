<?php

namespace Timeline;

use Ivy\Model\Profile;
use Ivy\Path;
use Ivy\View\LatteView;

class TimelineTemplate
{
    public function render($item): void
    {
        $timeline = (new Timeline)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();
        LatteView::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'timeline' => $timeline,
            'author' => $author
        ]);
    }
}
