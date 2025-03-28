<?php

namespace Tag;

use Ivy\Abstract\Model;

class Tag extends Model
{
    protected string $table = 'tag';
    protected string $path = 'plugin/tag';
    protected array $columns = [
        'value'
    ];

    protected string $value;
}
