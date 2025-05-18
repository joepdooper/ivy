<?php

namespace Items\Collection\Documentation;

use Items\Item;
use Ivy\Abstract\Model;

class Documentation extends Model
{
    protected string $table = "documentation";
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
