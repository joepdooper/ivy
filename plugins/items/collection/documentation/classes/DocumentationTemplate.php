<?php

namespace Items\Collection\Documentation;

use Items\Item;
use Ivy\Model\Profile;
use Ivy\Model\Setting;
use Ivy\Path;
use Ivy\View\View;
use Tags\Tag;

class DocumentationTemplate
{
    public function render($item): void
    {
        $documentation = (new Documentation)->where('id', $item->table_id)->fetchOne();

        if(!DocumentationPolicy::read($documentation, $item)){
            return;
        }

        View::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'documentation' => $documentation,
            'tag' => (new Tag)->where('id', $documentation->subject)->fetchOne(),
            'author' => (new Profile)->where('id', $item->user_id)->fetchOne()
        ]);
    }

    public function page($slug): void
    {
        $item = (new Item)->where('slug', $slug)->fetchOne();
        $documentation = (new Documentation)->where('id', $item->table_id)->fetchOne();

        if(!DocumentationPolicy::read($documentation)){
            return;
        }

        Setting::getStash()['title']->value = Setting::getStash()['title']->value . " - " . $documentation->title;

        View::set(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/page.latte', [
            'item' => $item,
            'items' => (new Item)->where('parent_id', $item->id)->sortBy(['sort', 'date', 'id'])->fetchAll(),
            'documentation' => $documentation,
            'tag' => (new Tag)->where('id', $documentation->subject)->fetchOne(),
            'tags' => (new Tag)->fetchAll(),
            'author' => (new Profile)->where('id', $item->user_id)->fetchOne()
        ]);
    }
}
