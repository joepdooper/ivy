<?php

use Ivy\App;
use Ivy\Path;
use Ivy\Request;
use Ivy\Template;

// -- hooks

function add_darkmode_buttons(): void
{
    $_SESSION['darkMode'] = $_SESSION['darkMode'] ?? false;
    Template::render(Path::get('PLUGIN_PATH') . "darkmode/template/buttons.latte", ['checked' => $_SESSION['darkMode']]);
}

Template::hooks()->add_action('dark_mode_buttons', 'add_darkmode_buttons');

// -- assets

Template::addJS(Path::get('PLUGIN_PATH') . "darkmode/js/dark-mode.js");

// -- routes

App::router()->post('/darkmode/toggle', function () {
    $request = new Request();
    $_SESSION['darkMode'] = $request->input('darkMode') === true;
    exit;
});