<?php

namespace Moment;

use Items\Item;
use Ivy\Model\Info;
use Ivy\Model\Profile;
use Ivy\Core\Path;
use Ivy\Model\User;
use Ivy\View\View;
use Moment\Collection\MomentDateTime\MomentDateTime;

class MomentTemplate
{
    public function render($item): void
    {
        if (!(User::getAuth()->isLoggedIn() || $item->publish)) {
            return;
        }

        $moment = (new Moment)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();

        View::render(Path::get('PLUGINS_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'moment' => $moment,
            'momentDateTime' => $moment->getDateTime(),
            'momentLocation' => $moment->getLocation(),
            'author' => $author
        ]);
    }

    public function page($slug): void
    {
        $item = (new Item)->where('slug', $slug)->fetchOne();

        if (!$item->policy('read')) {
            return;
        }

        $moment = (new Moment)->where('id', $item->table_id)->fetchOne();

        Info::stashGet('title')->value = Info::stashGet('title')->value . " - " . $moment->title;

        View::set(Path::get('PLUGINS_PATH') . $item->plugin_url . '/template/page.latte', [
            'item' => $item,
            'moment' => $moment,
            'momentDateTime' => $moment->getDateTime(),
            'momentLocation' => $moment->getLocation(),
            'author' => (new Profile)->where('id', $item->user_id)->fetchOne(),
            'items' => (new Item)->where('parent_id', $item->id)->sortBy(['sort', 'date', 'id'])->fetchAll()
        ]);
    }
}
