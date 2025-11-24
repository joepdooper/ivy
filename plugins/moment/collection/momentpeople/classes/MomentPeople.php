<?php

namespace Moment\Collection\MomentPeople;

use Ivy\Abstract\Model;
use Ivy\Trait\Factory;

class MomentPeople extends Model
{
    use Factory;

    protected string $table = "moments_people";

    protected array $columns = [
        'moment_id',
        'user_id',
        'contact_id',
        'token'
    ];

    protected int $moment_id;
    protected ?string $user_id = null;
    protected ?string $contact_id = null;
    protected ?string $token = null;
}
