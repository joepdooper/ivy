<?php

namespace Items\Collection\Code;

use Ivy\Model\Profile;
use Ivy\Path;
use Ivy\View\View;

class CodeTemplate
{
    public function render($item): void
    {
        $code = (new Code)->where('id', $item->table_id)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->populate(['date' => $item->date])->fetchOne();
        $languages = ['css', 'php', 'javascript', 'shell', 'sql'];
        View::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/item.latte', [
            'item' => $item,
            'code' => $code,
            'author' => $author,
            'languages' => $languages
        ]);
    }
}
