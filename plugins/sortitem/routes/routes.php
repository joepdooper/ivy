<?php

use Ivy\Item;
use Ivy\User;

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->post('/item/sort/', function () {

            $_POST = json_decode(file_get_contents("php://input"), true);
            $item = new Item();

            foreach ($_POST['data'] as $key => $value) {
                $item->where('id', $value)->update(['sort' => $key]);
            }
            echo json_encode('success');
            exit;
        });
    }
}
