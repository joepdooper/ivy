<?php

use Ivy\Item;
use Ivy\Message;
use Ivy\User;

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {
        global $router;

        $router->post('/youtube/(\w+)/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($action, $id, $template_route = null, $template_id = null) {

            $parent_id = null;
            if (isset($template_id)) {
                $parent_id = (new Item)->where('slug', $template_id)->getRow()->single()->id;
            }

            $item = new Item();
            $youtube = new \Youtube\Item();

            $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

            switch ($action) {
                case 'insert':
                    $youtube->insert(['youtube_video_id' => 'aKydtOXW8mI']);
                    $item->insert(['template' => $id, 'parent' => $parent_id]);
                    Message::add('Youtube inserted', $redirect);
                    break;
                case 'update':
                    $item->where('id', $id)->getRow();
                    $youtube->where('id', $item->single()->table_id)->getRow();
                    $item->update(['published' => $_POST['publish_item']]);
                    $youtube->update(['youtube_video_id' => $_POST['youtube_video_id']]);
                    Message::add('Youtube updated', $redirect);
                    break;
                case 'delete':
                    $item->where('id', $id)->getRow();
                    $youtube->where('id', $item->single()->table_id)->getRow();
                    $item->delete();
                    $youtube->delete();
                    Message::add('Youtube deleted', $redirect);
                    break;
            }

        });

    }
}
