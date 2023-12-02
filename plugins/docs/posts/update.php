<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');

if($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isLoggedIn()){

  $title = isset($_POST['title']) ? trim($_POST['title']) : $docs->data->title;
  $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : $docs->data->subtitle;
  $subject = isset($_POST['tag']) ? trim($_POST['tag']) : $docs->data->subject;

}
?>
