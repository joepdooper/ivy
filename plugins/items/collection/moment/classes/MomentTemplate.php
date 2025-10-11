<?php

namespace Items\Collection\Moment;

use Ivy\Model\Profile;
use Ivy\Core\Path;
use Ivy\Model\User;
use Ivy\View\View;

class MomentTemplate
{
    public function render($item): void
    {
        if (!(User::getAuth()->isLoggedIn() || $item->published)) {
            return;
        }

        $moment = (new Moment)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();

        View::render(Path::get('PLUGINS_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'moment' => $moment,
            'author' => $author
        ]);
    }
}
