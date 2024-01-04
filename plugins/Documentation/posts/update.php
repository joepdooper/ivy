<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');

if($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isLoggedIn()){

  $title = isset($_POST['title']) ? trim($_POST['title']) : $documentation->data->title;
  $subtitle = isset($_POST['subtitle']) ? trim($_POST['subtitle']) : $documentation->data->subtitle;
  $subject = isset($_POST['tag']) ? trim($_POST['tag']) : $documentation->data->subject;

}
?>
