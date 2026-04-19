<?php

namespace Moments;

use Items\Item;
use Ivy\Core\Path;
use Ivy\Model\Info;
use Ivy\View\View;
use Tags\Tag;

class MomentTemplate
{
    public static function render($moment): void
    {
        if (! $moment->item->policy('view')) {
            return;
        }

        View::render(Path::get('PLUGINS_PATH').'/moment/template/item.latte', [
            'item' => $moment->item,
            'moment' => $moment,
            'momentDateTime' => $moment->getDateTime(),
            'momentLocation' => $moment->getLocation(),
            'momentPeople' => $moment->getPeople(),
        ]);
    }

    public function page($slug): void
    {
        $item = Item::query()->where('slug', $slug)->fetchOne();

        if (! $item->policy('view')) {
            return;
        }

        $moment = Moment::query()->where('item_id', $item->id)->fetchOne();

        Info::stashGet('title')->value = Info::stashGet('title')->value.' - '.$moment->title;

        View::set(Path::get('PLUGINS_PATH').'moment/template/page.latte', [
            'item' => $item,
            'moment' => $moment,
            'momentDateTime' => $moment->momentDateTime,
            'momentLocation' => $moment->momentLocation,
            'momentPeople' => $moment->momentPeople,
            'author' => $item->author,
            'items' => (new Item)->where('parent_id', $item->id)->sortBy(['sort', 'date', 'id'])->fetchAll(),
            'tags' => (new Tag)->fetchAll(),
        ]);
    }
}
