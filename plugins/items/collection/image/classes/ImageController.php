<?php

namespace Items\Collections\Image;

use Ivy\Controller;
use Ivy\Profile;
use Ivy\Template;

class ImageController extends Controller
{
    private Image $image;

    public function __construct()
    {
        $this->image = new Image;
    }

    public function item($item): void
    {
        if ($item->published || $item->author) {
            $image = $this->image->where('id', $item->table_id)->fetchOne();
            $author = (new Profile)->where('id', $item->user_id)->fetchOne();
            $author->date = $item->date;
            Template::render(_PLUGIN_PATH . $item->plugin_url . '/template/item.latte', ['item' => $item, 'image' => $image, 'author' => $author]);
        }
    }
}
