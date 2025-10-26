<?php

namespace Items\Collection\Documentation;

use Items\Item;
use Ivy\Model\Info;
use Ivy\Model\Profile;
use Ivy\Model\Setting;
use Ivy\Core\Path;
use Ivy\Model\User;
use Ivy\View\View;
use Tags\Tag;

class DocumentationTemplate
{
    public function render($item): void
    {
        if (!(User::getAuth()->isLoggedIn() || $item->publish)) {
            return;
        }

        $documentation = (new Documentation)->where('id', $item->table_id)->fetchOne();

        View::render(Path::get('PLUGINS_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'documentation' => $documentation,
            'tag' => (new Tag)->where('id', $documentation->subject)->fetchOne(),
            'author' => (new Profile)->where('id', $item->user_id)->fetchOne()
        ]);
    }

    public function page($slug): void
    {
        $item = (new Item)->where('slug', $slug)->fetchOne();

        if (!(User::getAuth()->isLoggedIn() || $item->publish)) {
            return;
        }

        $documentation = (new Documentation)->where('id', $item->table_id)->fetchOne();

        Info::stashGet('title')->value = Info::stashGet('title')->value . " - " . $documentation->title;

        View::set(Path::get('PLUGINS_PATH') . $item->plugin_url . '/template/page.latte', [
            'item' => $item,
            'items' => (new Item)->where('parent_id', $item->id)->sortBy(['sort', 'date', 'id'])->fetchAll(),
            'documentation' => $documentation,
            'tag' => (new Tag)->where('id', $documentation->subject)->fetchOne(),
            'tags' => (new Tag)->fetchAll(),
            'author' => (new Profile)->where('id', $item->user_id)->fetchOne()
        ]);
    }
}
