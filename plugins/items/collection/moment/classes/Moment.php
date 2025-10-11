<?php

namespace Items\Collection\Moment;

use Items\ItemTrait;
use Ivy\Abstract\Model;
use Ivy\Trait\Factory;
use Tags\TagTrait;

class Moment extends Model
{
    use ItemTrait, TagTrait, Factory;

    protected string $table = "moments";
    protected string $slug = "title";

    protected array $columns = [
        'title',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'token'
    ];

    protected string $title;
    protected string $start_date;
    protected ?string $end_date;
    protected ?string $start_time;
    protected ?string $end_time;
    protected ?string $token;
}
