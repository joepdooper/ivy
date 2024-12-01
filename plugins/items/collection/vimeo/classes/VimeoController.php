<?php

namespace Vimeo;

use Ivy\ItemController;
use Ivy\Template;

class VimeoController extends ItemController
{
    private Vimeo $vimeo;

    public function __construct()
    {
        $this->vimeo = new Vimeo;
        parent::__construct();
    }

    public function item(): void
    {
        if ($this->item->published || $this->item->author) {
            $vimeo = $this->vimeo->where('id', $this->item->table_id)->getRow()->single();
            Template::render(_PLUGIN_PATH . $this->item->plugin_url . '/template/item.latte', ['item' => $this->item, 'vimeo' => $vimeo]);
        }
    }
}
