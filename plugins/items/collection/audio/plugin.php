<?php

use Ivy\Template;

Template::addCSS("plugins/audio/css/audio.css");

function add_audio_admin_js(): void
{
    print "<script src='" . _BASE_PATH . _PLUGIN_PATH . "audio/js/audio_admin.js'></script>";
}

Template::hooks()->add_action('add_js_action', 'add_audio_admin_js');

include 'actions/routes.php';