<?php

namespace Article;

use Ivy\Controller;
use Ivy\Item;
use Ivy\ItemHelper;
use Ivy\Profile;
use Ivy\Setting;
use Ivy\Template;
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
        $item = $this->item->where('slug', $slug)->getRow()->single();
        if ($item->published || $item->author) {
            $article = $this->article->where('id', $item->table_id)->getRow()->single();
            $tag = (new Tag)->where('id', $article->subject)->getRow()->single();
            $author = (new Profile)->where('id', $item->user_id)->getRow()->single();
            $author->date = $item->date;
            Setting::$stash['title']->value = Setting::$stash['title']->value . " - " . $article->title;
            $items = (new Item)->where('parent', $item->id)->orderBy(['sort', 'date', 'id'])->get()->all();
            ItemHelper::getPluginControllerClasses($items);
            Template::view(_PLUGIN_PATH . $item->plugin_url . '/template/page.latte', ['item' => $item, 'article' => $article, 'tag' => $tag, 'author' => $author, 'items' => $items]);
        }
    }

    public function item($item): void
    {
        if ($item->published || $item->author) {
            $article = $this->article->where('id', $item->table_id)->getRow()->single();
            $tag = (new Tag)->where('id', $article->subject)->getRow()->single();
            $author = (new Profile)->where('id', $item->user_id)->getRow()->single();
            $author->date = $item->date;
            Template::render(_PLUGIN_PATH . $item->plugin_url . '/template/item.latte', ['item' => $item, 'article' => $article, 'tag' => $tag, 'author' => $author]);
        }
    }
}
