<?php

use Ivy\Language;
use Ivy\Path;
use Ivy\Setting;

function _t($language_key)
{
    return Language::translate($language_key);
}

function _p($path_key)
{
    return Path::get($path_key);
}

function _s($settings_key): void
{
    echo isset(Setting::getStash()[$settings_key]) ? Setting::getStash()[$settings_key]?->getValue() : '';
}