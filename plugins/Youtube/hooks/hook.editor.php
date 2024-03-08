<?php
defined('_BASE_PATH') or die('Something went wrong');
global $auth;

if($auth->isLoggedIn()){
    if(\Ivy\User::canEditAsEditor($auth)){
        global $router;

        $router->post('/youtube/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $template_route = null, $template_id = null) {

            $item = new \Ivy\Item();
            $youtube = new \Youtube\Item();

            $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

            switch ($action) {
                case 'insert':
                    $youtube->insert(['youtube_video_id' => 'aKydtOXW8mI']);
                    $item->insert(['template' => $id, 'parent' => $template_id]);
                    \Ivy\Message::add('Youtube inserted', $redirect);
                    break;
                case 'update':
                    $item->where('id', $id)->getRow();
                    $youtube->where('id', $item->data->table_id)->getRow();
                    $item->update(['published' => $_POST['publish_item']]);
                    $youtube->update(['youtube_video_id' => $_POST['youtube_video_id']]);
                    \Ivy\Message::add('Youtube updated', $redirect);
                    break;
                case 'delete':
                    $item->where('id', $id)->getRow();
                    $youtube->where('id', $item->data->table_id)->getRow();
                    $item->delete();
                    $youtube->delete();
                    \Ivy\Message::add('Youtube deleted', $redirect);
                    break;
            }

        });

    }
}
