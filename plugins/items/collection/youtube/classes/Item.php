<?php

namespace Youtube;

use Ivy\Model;

class Item extends Model
{
    public int $id;
    public string $token;

    protected string $table = "youtube";
}
