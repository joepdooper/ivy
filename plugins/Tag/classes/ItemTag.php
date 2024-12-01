<?php

namespace Tag;

use Ivy\Model;

class ItemTag extends Model
{

    protected string $table = 'item_tag';
    protected string $path = _BASE_PATH . 'plugin/Tag';

    public function __construct()
    {
        parent::__construct();
        $this->join('tag', 'tag_id', '=', 'id');
    }

    public function getItemTags($item_id): object|array
    {
        return (new self)->where('item_id', $item_id)->get()->all();
    }

}