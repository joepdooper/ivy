<?php

namespace Items\Collection\Article;

use Ivy\Abstract\Model;

class Article extends Model
{
    protected string $table = "article";
    protected array $columns = [
        'title',
        'subtitle',
        'subject',
        'image',
        'token'
    ];

    protected string $title;
    protected ?string $subtitle;
    protected int $subject;
    protected ?string $image;
    protected ?string $token;
}
