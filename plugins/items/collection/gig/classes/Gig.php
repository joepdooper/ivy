<?php

namespace Items\Collection\Gig;

use Ivy\Abstract\Model;

class Gig extends Model
{
    protected string $table = "gigs";
    protected array $columns = [
        'datetime',
        'venue',
        'address',
        'latitude',
        'longitude',
        'price',
        'url',
        'subject',
        'token'
    ];

    protected string $datetime;
    protected ?string $venue;
    protected ?string $address;
    protected ?float $latitude;
    protected ?float $longitude;
    protected ?float $price;
    protected ?string $url;
    protected int $subject;
    protected ?string $token;
}
