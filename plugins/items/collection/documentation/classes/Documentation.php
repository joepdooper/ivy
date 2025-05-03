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
        'token'
    ];

    protected string $title;
    protected ?string $subtitle;
    protected int $subject;
    protected ?string $token;
}
