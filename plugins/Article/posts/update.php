<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');

if($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isLoggedIn()){

  $title = isset($_POST['title']) ? trim($_POST['title']) : $article->data->title;
  $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : $article->data->subtitle;
  $subject = isset($_POST['tag']) ? trim($_POST['tag']) : $article->data->subject;
  $image = isset($_POST['delete_image']) ? NULL : (isset($_POST['image']) ? trim($_POST['image']) : $article->data->image);

  if (isset($_POST['delete_image'])) {
    (new \Image\Item)->delete_file($article->data->image);
  }

  if(!empty($_FILES['upload_image']['name'])){
    $image = (new \Image\Item)->upload($_FILES['upload_image']);
  }

}
?>
