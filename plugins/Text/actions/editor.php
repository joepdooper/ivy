<?php
defined('_BASE_PATH') or die('Something went wrong');
global $auth;

if($auth->isLoggedIn()){
    if(\Ivy\User::canEditAsEditor($auth)){

        global $router;
        $router->post('/text/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $template_route = null, $template_id = null) {

            $item = new \Ivy\Item();
            $text = new \Text\Item();

            $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

            switch ($action) {
                case 'insert':
                    $text->insert(['text' => 'Write…']);
                    $item->insert(['template' => $id, 'parent' => $template_id]);
                    \Ivy\Message::add('Text inserted', $redirect);
                    break;
                case 'update':
                    $item->where('id', $id)->getRow();
                    $text->where('id', $item->data->table_id)->getRow();
                    $item->update(['published' => $_POST['publish_item']]);
                    $text->update(['text' => $_POST['text']]);
                    \Ivy\Message::add('Text updated', $redirect);
                    break;
                case 'delete':
                    $item->where('id', $id)->getRow();
                    $text->where('id', $item->data->table_id)->getRow();
                    $item->delete();
                    $text->delete();
                    \Ivy\Message::add('Text deleted', $redirect);
                    break;
            }

        });


        function add_text_toolbar(): void
        {
            include \Ivy\Template::file(_PLUGIN_PATH . 'Text/template/toolbar.php');
        }

        function add_text_admin_js(): void
        {
            print "<script src='" . _BASE_PATH . _PLUGIN_PATH . "Text/js/text_admin.js'></script>";
        }

        global $hooks;
        $hooks->add_action('end_footer_action','add_text_toolbar');
        $hooks->add_action('add_js_action','add_text_admin_js');

    }
}
