<?php
defined('_BASE_PATH') or die('Something went wrong');

use Ivy\Item;
use Ivy\Message;
use Ivy\User;

global $auth;

if($auth->isLoggedIn()){
    if(User::canEditAsEditor($auth)){
        global $router, $db;

        $router->post('/article/(\w+)/(\d+)(/\w+)?(/\d+)?', function($action, $id, $template_route = null, $template_id = null) use($db,$auth) {

            $item = new Item();
            $article = new \Article\Item();

            $redirect = _BASE_PATH . (isset($template_id) && $action != 'delete' ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($template_id) : "");

            switch ($action) {
                case 'insert':
                    $article->insert(['title' => 'Title', 'subtitle' => 'Subtitle', 'subject' => $db->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1',[])]);
                    $item->insert(['template' => $id, 'parent' => $template_id]);
                    Message::add('Article inserted', $redirect);
                    break;
                case 'update':
                    $item->where('id', $id)->getRow();
                    $article->where('id', $item->data->table_id)->getRow();
                    if(isset($_POST['datetime'])){
                        $item->update(['published' => $_POST['publish_item'], 'date' => $_POST['datetime']]);
                    } else {
                        $item->update(['published' => $_POST['publish_item']]);
                    }

                    $title = isset($_POST['title']) ? trim($_POST['title']) : $article->data->title;
                    $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : $article->data->subtitle;
                    $subject = isset($_POST['tag']) ? trim($_POST['tag']) : $article->data->subject;
                    $image = isset($_POST['delete_image']) ? NULL : (isset($_POST['image']) ? trim($_POST['image']) : $article->data->image);

                    if (isset($_POST['delete_image'])) {
                        (new \Image\Item)->delete_set($article->data->image);
                    }

                    if(!empty($_FILES['upload_image']['name'])){
                        $image = (new \Image\Item)->upload($_FILES['upload_image']);
                    }

                    $article->update(['title' => $title, 'subtitle' => $subtitle, 'subject' => $subject, 'image' => $image]);
                    Message::add('Article updated', $redirect);
                    break;
                case 'delete':
                    $item->where('id', $id)->getRow();
                    $article->where('id', $item->data->table_id)->getRow();
                    if($article->data->image){
                        (new \Image\Item)->delete_set($article->data->image);
                    }
                    $item->delete();
                    $article->delete();
                    Message::add('Article deleted', $redirect);
                    break;
            }

        });

    }
}
