<?php

namespace Items\Collection\Article;

use Items\Item;
use Ivy\Model\Info;
use Ivy\Model\Profile;
use Ivy\Core\Path;
use Ivy\View\View;

class ArticleTemplate
{
    public function render($item): void
    {
        $article = (new Article)->fetchOneWithItem($item);

        if(!ArticlePolicy::read($article)){
            return;
        }

        View::render(Path::get('PLUGINS_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'article' => $article,
            'author' => (new Profile)->where('id', $item->user_id)->fetchOne()
        ]);
    }

    public function page($slug): void
    {
        $article = (new Article)->fetchOneWithSlug($slug);

        if(!ArticlePolicy::read($article)){
            return;
        }

        Info::getStash()['title']->value = Info::getStash()['title']->value . " - " . $article->title;

        View::set(Path::get('PLUGINS_PATH') . $article->getItem()->plugin_url . '/template/page.latte', [
            'item' => $article->getItem(),
            'article' => $article,
            'author' => (new Profile)->where('id', $article->getItem()->user_id)->fetchOne(),
            'items' => (new Item)->where('parent_id', $article->getItem()->id)->sortBy(['sort', 'date', 'id'])->fetchAll()
        ]);
    }
}
