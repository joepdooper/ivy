<?php

// -- hooks

function add_darkmode_buttons(): void
{
    $_SESSION['darkMode'] = $_SESSION['darkMode'] ?? false;
    Template::render(Path::get('PLUGINS_PATH') . "darkmode/template/buttons.latte", ['checked' => $_SESSION['darkMode']]);
}

// -- assets

AssetManager::addJS(Path::get('PLUGINS_PATH') . "darkmode/js/dark-mode.js");

// -- routes

RouterManager::instance()->post('/darkmode/toggle', function () {
    $request = new Request();
    $_SESSION['darkMode'] = $request->input('darkMode') === true;
    exit;
});