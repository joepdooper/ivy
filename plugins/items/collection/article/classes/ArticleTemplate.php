<?php

namespace Items\Collection\Article;

use Ivy\Model\Profile;
use Ivy\Path;
use Ivy\View\LatteView;

class ArticleTemplate
{
    public function render($item): void
    {
        $article = (new Article)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();
        LatteView::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'article' => $article,
            'author' => $author
        ]);
    }
}
