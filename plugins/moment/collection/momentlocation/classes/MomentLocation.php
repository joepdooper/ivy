<?php

namespace Moment\Collection\MomentLocation;

use Ivy\Abstract\Model;
use Ivy\Trait\Factory;

class MomentLocation extends Model
{
    use Factory;

    protected string $table = "moments_location";

    protected array $columns = [
        'moment_id',
        'city',
        'country',
        'country_code',
        'latitude',
        'longitude',
        'token'
    ];

    protected int $moment_id;
    protected ?string $city;
    protected ?string $country;
    protected ?string $country_code;
    protected ?float $latitude;
    protected ?float $longitude;
    protected ?string $token;
}
