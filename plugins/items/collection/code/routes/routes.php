<?php


use Ivy\Item;
use Ivy\Message;
use Ivy\User;

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {

        global $router;
        $router->post('/code/(\w+)/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($action, $id, $template_route = null, $template_id = null) {

            $parent_id = null;
            if (isset($template_id)) {
                $parent_id = (new Item)->where('slug', $template_id)->getRow()->single()->id;
            }

            $item = new Item();
            $code = new \Code\Item();

            $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

            switch ($action) {
                case 'insert':
                    $code->insert(['code' => 'Insert code…', 'language' => 'php']);
                    $item->insert(['template' => $id, 'parent' => $parent_id]);
                    Message::add('Code inserted', $redirect);
                    break;
                case 'update':
                    $item->where('id', $id)->getRow();
                    $code->where('id', $item->single()->table_id)->getRow();
                    $item->update(['published' => $_POST['publish_item']]);
                    $code->update(['code' => $_POST['code'], 'language' => $_POST['language']]);
                    Message::add('Code updated', $redirect);
                    break;
                case 'delete':
                    $item->where('id', $id)->getRow();
                    $code->where('id', $item->single()->table_id)->getRow();
                    $item->delete();
                    $code->delete();
                    Message::add('Code deleted', $redirect);
                    break;
            }

        });

    }
}
