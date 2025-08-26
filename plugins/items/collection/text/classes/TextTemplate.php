<?php

namespace Items\Collection\Text;

use Ivy\Model\Profile;
use Ivy\Core\Path;
use Ivy\Model\User;
use Ivy\View\View;

class TextTemplate
{
    public function render($item): void
    {
        if (!(User::getAuth()->isLoggedIn() || $item->published)) {
            return;
        }

        $text = (new Text)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();

        View::render(Path::get('PLUGINS_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'text' => $text,
            'author' => $author
        ]);
    }
}
