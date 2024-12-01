<?php

namespace Vimeo;

use Ivy\Model;

class Vimeo extends Model
{
    public int $id;
    public string $token;
    protected string $table = "vimeo";
}
