<?php

use Ivy\Item;
use Ivy\Message;
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

global $router;

if (User::isLoggedIn()) {
    if (User::canEditAsEditor()) {

        global $router, $auth;
        $router->post('/documentation/(\w+)/(\d+)(/\w+)?(/[a-z0-9_-]+)?', function ($action, $id, $template_route = null, $template_id = null) use ($auth) {

            $parent_id = null;
            if (isset($template_id)) {
                $parent_id = (new Item)->where('slug', $template_id)->getRow()->single()->id;
            }

            $item = new Item();
            $documentation = new \Documentation\Item();

            $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

            switch ($action) {

                case 'insert':

                    $slug = $item->createSlug('Title');
                    $documentation->insert(['item_template_id' => $id, 'title' => 'Title', 'subtitle' => 'Subtitle', 'subject' => DB::$connection->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1', [])]);
                    $documentation_id = DB::$connection->getLastInsertId();
                    $item->insert(['template' => $id, 'parent' => $parent_id, 'slug' => $slug]);
                    $documentation->where('id', $documentation_id)->update(['item_id' => DB::$connection->getLastInsertId()]);
                    Message::add('Documentation inserted', $redirect);
                    break;

                case 'update':

                    $item->where('id', $id)->getRow();
                    $documentation->where('id', $item->single()->table_id)->getRow();

                    $item->update(['published' => $_POST['publish_item']]);

                    $title = isset($_POST['title']) ? trim($_POST['title']) : $documentation->single()->title;
                    $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : $documentation->single()->subtitle;
                    $subject = isset($_POST['tag']) ? trim($_POST['tag']) : $documentation->single()->subject;
                    $slug = $item->createSlug($title);

                    $documentation->update(['title' => $title, 'subtitle' => $subtitle, 'subject' => $subject]);
                    $item->update(['slug' => $slug]);

                    $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($slug) : "");
                    Message::add('Documentation updated', $redirect);
                    break;

                case 'delete':

                    $item->where('id', $id)->getRow();
                    $documentation->where('id', $item->single()->table_id)->getRow();
                    $item->delete();
                    $documentation->delete();
                    Message::add('Documentation deleted', $redirect);
                    break;

            }

        });

    }
}

$router->get('/documentation/([a-z0-9_-]+)', function ($slug) {
    $item = (new Item)->where('slug', $slug)->getRow()->single();
    $documentation = (new \Documentation\Item)->where('id', $item->table_id)->getRow()->single();
    $tags = (new \Tag\Item)->get()->all();
    Setting::$stash['title']->value = Setting::$stash['title']->value . " - " . $documentation->title;
    if ($item->published || $item->author) {
        Template::render(_PLUGIN_PATH . $item->plugin_url . '/template/page.php', ['item' => $item, 'documentation' => $documentation, 'tags' => $tags], 'main');
    }
});