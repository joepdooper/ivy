<?php

namespace Items\Collection\Article;

use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;
use Tag\Tag;

class ArticleController extends Controller
{
    private Article $article;
    private Item $item;

    public function __construct()
    {
        $this->article = new Article();
        $this->item = new Item();
    }

    public function page($slug): void
    {
        $item = $this->item->where('slug', $slug)->fetchOne();
        if ($item->published || $item->author) {
            $article = $this->article->where('id', $item->table_id)->fetchOne();
            $tag = (new Tag)->where('id', $article->subject)->fetchOne();
            $author = (new Profile)->where('id', $item->user_id)->fetchOne();
            $author->date = $item->date;
            Setting::getStash()['title']->value = Setting::getStash()['title']->value . " - " . $article->title;
            $items = (new Item)->where('parent', $item->id)->orderBy(['sort', 'date', 'id'])->get()->all();
            ItemHelper::getPluginControllerClasses($items);
            Template::view(_PLUGIN_PATH . $item->plugin_url . '/template/page.latte', ['item' => $item, 'article' => $article, 'tag' => $tag, 'author' => $author, 'items' => $items]);
        }
    }

    public function item($item): void
    {
        if ($item->published || $item->author) {
            $article = $this->article->where('id', $item->table_id)->fetchOne();
            $tag = (new Tag)->where('id', $article->subject)->fetchOne();
            $author = (new Profile)->where('id', $item->user_id)->fetchOne();
            $author->date = $item->date;
            Template::render(_PLUGIN_PATH . $item->plugin_url . '/template/item.latte', ['item' => $item, 'article' => $article, 'tag' => $tag, 'author' => $author]);
        }
    }
}
