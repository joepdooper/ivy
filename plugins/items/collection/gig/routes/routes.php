<?php


use Ivy\DB;
use Ivy\Item;
use Ivy\User;

if (User::getAuth()->isLoggedIn()) {
    if (User::canEditAsEditor()) {

        global $router, $auth;
        $router->post('/gig/(\w+)/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($action, $id, $template_route = null, $template_id = null) use ($auth) {

            $parent_id = null;
            if (isset($template_id)) {
                $parent_id = (new Item)->where('slug', $template_id)->fetchOne()->id;
            }

            $item = new Item();
            $gig = new \Gig\Item();

            $redirect = (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

            switch ($action) {
                case 'insert':
                    $gig->insert(['datetime' => date("Y-m-d H:i:s"), 'venue' => 'Venue', 'address' => 'Address', 'subject' => DatabaseManager::connection()->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1', [])]);
                    $item->insert(['template' => $id, 'parent' => $parent_id]);
                    Message::add('Gig inserted', $redirect);
                    break;
                case 'update':
                    $item->where('id', $id)->getRow();
                    $gig->where('id', $item->single()->table_id)->getRow();
                    $item->update(['published' => $_POST['publish_item']]);
                    $date = isset($_POST['date']) ? trim($_POST['date']) : NULL;
                    $time = isset($_POST['time']) ? trim($_POST['time']) : NULL;
                    $venue = isset($_POST['venue']) ? trim($_POST['venue']) : NULL;
                    $address = isset($_POST['address']) ? trim($_POST['address']) : NULL;
                    $subject = isset($_POST['tag']) ? trim($_POST['tag']) : NULL;
                    $gig->update(['datetime' => $date . ' ' . $time, 'venue' => $venue, 'address' => $address, 'subject' => $subject]);
                    Message::add('gig updated', $redirect);
                    break;
                case 'delete':
                    $item->where('id', $id)->getRow();
                    $gig->where('id', $item->single()->table_id)->getRow();
                    $item->delete();
                    $gig->delete();
                    Message::add('Gig deleted', $redirect);
                    break;
            }

        });

    }
}