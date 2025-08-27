<?php

namespace Items\Collection\Article;

use Items\Item;
use Ivy\Model\User;

class ArticlePolicy
{
    public static function create(Article $article): bool
    {
        return User::canEditAsAdmin();
    }

    public static function update(Article $article): bool
    {
        return User::canEditAsEditor();
    }

    public static function delete(Article $article): bool
    {
        return User::canEditAsAdmin();
    }
}