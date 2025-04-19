<?php

namespace Items\Collection\Documentation;

use Ivy\Model;

class Item extends Model
{

    public int $id;
    public string $title;
    public string $subtitle;
    public int $subject;

    public string $token;
    protected string $table = "documentation";

}