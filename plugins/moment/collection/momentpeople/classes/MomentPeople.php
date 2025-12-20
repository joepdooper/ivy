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
        'people_id',
        'token'
    ];

    protected int $moment_id;
    protected int $people_id;
    protected ?string $token = null;

    public function getPeople(): array
    {
        return $this->hasMany(People::class, 'people_id');
    }

    public function getMoment(): array
    {
        return $this->hasMany(Moment::class, 'moment_id');
    }
}
