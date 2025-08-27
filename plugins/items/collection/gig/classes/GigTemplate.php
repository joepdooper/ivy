<?php

namespace Items\Collection\Gig;

use Ivy\Model\Profile;
use Ivy\Core\Path;
use Ivy\Model\User;
use Ivy\View\View;
use Tags\Tag;

class GigTemplate
{
    public function render($item): void
    {
        if (!(User::getAuth()->isLoggedIn() || $item->published)) {
            return;
        }

        $gig = (new Gig)->where('id', $item->table_id)->fetchOne();

        View::render(Path::get('PLUGINS_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'gig' => $gig,
            'tag' => (new Tag)->where('id', $gig->subject)->fetchOne(),
            'author' => (new Profile)->where('id', $item->user_id)->fetchOne()
        ]);
    }
}
