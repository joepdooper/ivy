<?php

namespace Sitemap;

use Ivy\Model;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;

class Settings extends Model
{

    public $id, $url, $token;
    protected string $table = "sitemap";
    protected string $path = _BASE_PATH . 'plugin/sitemap';

}