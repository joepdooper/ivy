<?php

namespace Items\Collection\Article;

use Ivy\Abstract\Model;

class Article extends Model
{

    protected string $table = "article";

    public int $id;
    public string $title;
    public int $subject;
    public string $image;
    public int $token;

}
