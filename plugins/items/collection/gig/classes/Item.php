<?php

namespace Gig;

use Ivy\Model;

class Item extends Model
{
    public int $id;
    public string $datetime;
    public string $venue;
    public string $address;
    public string $price;
    public string $url;
    public int $subject;
    public string $token;

    protected string $table = "gig";

}
