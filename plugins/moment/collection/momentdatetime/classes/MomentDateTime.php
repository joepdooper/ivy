<?php

namespace Moment\Collection\MomentDateTime;

use Ivy\Abstract\Model;
use Ivy\Trait\Factory;

class MomentDateTime extends Model
{
    use Factory;

    protected string $table = "moments_date_time";

    protected array $columns = [
        'moment_id',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'token'
    ];

    protected int $moment_id;
    protected string $start_date;
    protected ?string $end_date;
    protected ?string $start_time;
    protected ?string $end_time;
    protected ?string $token;
}
