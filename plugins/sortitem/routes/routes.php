<?php

use Ivy\Model\User;

if (User::getAuth()->isLoggedIn()) {
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
