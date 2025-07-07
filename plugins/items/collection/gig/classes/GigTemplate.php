<?php

namespace Items\Collection\Gig;

use Ivy\Model\Profile;
use Ivy\Path;
use Ivy\View\View;
use Tags\Tag;

class GigTemplate
{
    public function render($item): void
    {
        $gig = (new Gig)->where('id', $item->table_id)->fetchOne();

        if(!GigPolicy::read($gig, $item)){
            return;
        }

        View::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'gig' => $gig,
            'tag' => (new Tag)->where('id', $gig->subject)->fetchOne(),
            'author' => (new Profile)->where('id', $item->user_id)->fetchOne()
        ]);
    }
}
