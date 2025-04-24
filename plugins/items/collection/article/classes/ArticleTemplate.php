<?php

namespace Items\Collection\Article;

use Items\Item;
use Items\ItemTemplate;
use Ivy\Model\Profile;
use Ivy\Model\Setting;
use Ivy\Path;
use Ivy\View\LatteView;
use Tag\Tag;

class ArticleTemplate
{
    public function render($item): void
    {
        $article = (new Article)->where('id', $item->table_id)->fetchOne();

        if(!ArticlePolicy::read($article, $item)){
            return;
        }

        LatteView::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'article' => $article,
            'tag' => (new Tag)->where('id', $article->subject)->fetchOne(),
            'author' => (new Profile)->where('id', $item->user_id)->fetchOne()
        ]);
    }

    public function page($slug): void
    {
        $item = (new Item)->where('slug', $slug)->fetchOne();
        $article = (new Article)->where('id', $item->table_id)->fetchOne();

        if(!ArticlePolicy::read($article, $item)){
            return;
        }

        Setting::getStash()['title']->value = Setting::getStash()['title']->value . " - " . $article->title;

        LatteView::set(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/page.latte', [
            'item' => $item,
            'article' => $article,
            'tag' => (new Tag)->where('id', $article->subject)->fetchOne(),
            'author' => (new Profile)->where('id', $item->user_id)->fetchOne(),
            'items' => (new Item)->where('parent_id', $item->id)->sortBy(['sort', 'date', 'id'])->fetchAll()
        ]);
    }
}
