<?php

global $router;

use Items\Item;
use Items\ItemHelper;
use Items\ItemTemplate;
use Ivy\Request;
use Ivy\Template;
use Ivy\User;

$router->get('/', function () {
    $items = (new Item)->where('parent')->orderBy(['sort', 'date', 'id'])->get()->all();
    $items = ItemHelper::getPluginControllerClasses($items);
    $item_templates = (new ItemTemplate)->get()->all();
    Template::view(_PLUGIN_PATH . 'items/template/overview.latte', ['items' => $items, 'item_templates' => $item_templates]);
});

if (User::isLoggedIn()) {
    if (User::canEditAsAdmin()) {
        global $router;
        $router->get('/plugin/items', function () {
            Template::view(_PLUGIN_PATH . 'items/template/settings.latte', ['tags' => null]);
        });
        $router->post('/item_template/insert', function () {
            $request = new Request();
            $itemTemplate = (new ItemTemplate)->where('id', $request->input('id'))->getRow()->single();
            $pluginRoute = isset($itemTemplate->route) ? _BASE_PATH . $itemTemplate->route . DIRECTORY_SEPARATOR . 'insert' . DIRECTORY_SEPARATOR . $request->input('id') : _BASE_PATH;
            header('location:' . $pluginRoute, true, 302);
            exit;
        });
    }
}