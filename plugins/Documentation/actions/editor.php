<?php
defined('_BASE_PATH') or die('Something went wrong');
global $auth;

if($auth->isLoggedIn()){
    if(\Ivy\User::canEditAsEditor($auth)){

        global $router, $db, $auth;
        $router->post('/documentation/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $template_route = null, $template_id = null) use($db, $auth) {

            $item = new \Ivy\Item();
            $documentation = new \Documentation\Item();

            $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

            switch ($action) {
                case 'insert':
                    $documentation->insert(['item_template_id' => $id, 'title' => 'Title', 'subtitle' => 'Subtitle', 'subject' => $db->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1',[])]);
                    $documentation_id = $db->getLastInsertId();
                    $item->insert(['template' => $id, 'parent' => $template_id]);
                    $documentation->where('id', $documentation_id)->update(['item_id' => $db->getLastInsertId()]);
                    \Ivy\Message::add('Documentation inserted', $redirect);
                    break;
                case 'update':
                    $item->where('id', $id)->getRow();
                    $documentation->where('id', $item->data->table_id)->getRow();
                    $item->update(['published' => $_POST['publish_item']]);
                    $title = isset($_POST['title']) ? trim($_POST['title']) : $documentation->data->title;
                    $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : $documentation->data->subtitle;
                    $subject = isset($_POST['tag']) ? trim($_POST['tag']) : $documentation->data->subject;
                    $documentation->update(['title' => $title, 'subtitle' => $subtitle, 'subject' => $subject]);
                    \Ivy\Message::add('Documentation updated', $redirect);
                    break;
                case 'delete':
                    $item->where('id', $id)->getRow();
                    $documentation->where('id', $item->data->table_id)->getRow();
                    $item->delete();
                    $documentation->delete();
                    \Ivy\Message::add('Documentation deleted', $redirect);
                    break;
            }

        });

    }
}
