<?php
defined('_BASE_PATH') or die('Something went wrong');
global $auth;

if($auth->isLoggedIn()){
    if(canEditAsEditor($auth)){

        global $router, $db, $auth;
        $router->post('/gig/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $template_route = null, $template_id = null) use($db, $auth) {

            $item = new \Ivy\Item();
            $gig = new \Gig\Item();

            $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

            switch ($action) {
                case 'insert':
                    $gig->insert(['datetime' => date("Y-m-d H:i:s"), 'venue' => 'Venue', 'address' => 'Address', 'subject' => $db->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1',[])]);
                    $item->insert(['template' => $id, 'parent' => $template_id]);
                    \Ivy\Message::add('Gig inserted', $redirect);
                    break;
                case 'update':
                    $item->where('id', $id)->getRow();
                    $gig->where('id', $item->data->table_id)->getRow();
                    $item->update(['published' => $_POST['publish_item']]);
                    $date = isset($_POST['date']) ? trim($_POST['date']) : NULL;
                    $time = isset($_POST['time']) ? trim($_POST['time']) : NULL;
                    $venue = isset($_POST['venue']) ? trim($_POST['venue']) : NULL;
                    $address = isset($_POST['address']) ? trim($_POST['address']) : NULL;
                    $subject = isset($_POST['tag']) ? trim($_POST['tag']) : NULL;
                    $gig->update(['datetime' => $date . ' ' . $time, 'venue' => $venue, 'address' => $address, 'subject' => $subject]);
                    \Ivy\Message::add('gig updated', $redirect);
                    break;
                case 'delete':
                    $item->where('id', $id)->getRow();
                    $gig->where('id', $item->data->table_id)->getRow();
                    $item->delete();
                    $gig->delete();
                    \Ivy\Message::add('Gig deleted', $redirect);
                    break;
            }

        });

    }
}
