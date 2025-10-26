<?php

namespace Sitemap;

use Ivy\Model;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;

class Settings extends Model
{
    protected string $table = "sitemap";
    protected string $path = 'plugin/sitemap';
}