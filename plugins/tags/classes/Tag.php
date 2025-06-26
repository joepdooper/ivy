<?php

namespace Tags;

use Ivy\Abstract\Model;

class Tag extends Model
{
    protected string $table = 'tags';
    protected string $path = 'plugin/tag';
    protected array $columns = [
        'value'
    ];

    protected string $value;
}
