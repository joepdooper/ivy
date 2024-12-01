<?php

namespace Text;

use Ivy\Controller;
use Ivy\Profile;
use Ivy\Template;

class TextController extends Controller
{
    private Text $text;

    public function __construct()
    {
        $this->text = new Text();
    }

    public function item($item): void
    {
        if ($item->published || $item->author) {
            $text = $this->text->where('id', $item->table_id)->getRow()->single();
            $author = (new Profile)->where('id', $item->user_id)->getRow()->single();
            $author->date = $item->date;
            Template::render(_PLUGIN_PATH . $item->plugin_url . '/template/item.latte', ['item' => $item, 'text' => $text, 'author' => $author]);
        }
    }
}
