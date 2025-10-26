<?php

namespace Search;

use Ivy\Abstract\Model;

class Search extends Model
{
    protected string $table = 'search';
    protected string $path = '/';
    protected array $columns = [
        'value'
    ];

    protected string $value;
}
