<?php

namespace Items\Collection\Documentation;

use Items\Item;
use Items\ItemTrait;
use Ivy\Abstract\Model;
use Tags\TagTrait;

class Documentation extends Model
{
    use ItemTrait, TagTrait;

    protected string $table = "documentations";
    protected array $columns = [
        'title',
        'subtitle',
        'subject',
        'item_id',
        'token'
    ];

    protected string $title;
    protected ?string $subtitle;
    protected int $subject;
    protected ?int $item_id;
    protected ?string $token;

    public function item(): ?Model
    {
        return $this->hasOne(Item::class,  'id', 'item_id');
    }
}
