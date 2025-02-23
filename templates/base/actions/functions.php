<?php

use Ivy\Language;
use Ivy\Path;

function _t($language_key)
{
    return Language::translate($language_key);
}

function _p($path_key)
{
    return Path::get($path_key);
}