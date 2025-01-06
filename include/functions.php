<?php

use Ivy\Language;

function __($language_key)
{
    return Language::get($language_key);
}