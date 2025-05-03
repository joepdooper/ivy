<?php

namespace Items\Collection\Documentation;

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

    protected ?int $published;
    protected ?string $slug;

    protected function setPublished(int $published): void
    {
        $this->published = $published;
    }

    protected function getPublished(): int
    {
        return $this->published;
    }

    protected function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    protected function getSlug(): string
    {
        return $this->slug;
    }
}
