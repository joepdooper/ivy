<?php

namespace Items\Collection\Image;

use Ivy\Abstract\Model;

class Image extends Model
{
    protected string $table = 'images';
    protected array $columns = [
        'file',
        'token'
    ];

    protected ?string $file;
    protected ?string $token;
}
