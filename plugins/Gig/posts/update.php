<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');

if($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isLoggedIn()){

  $date = isset($_POST['date']) ? trim($_POST['date']) : NULL;
  $time = isset($_POST['time']) ? trim($_POST['time']) : NULL;
  $venue = isset($_POST['venue']) ? trim($_POST['venue']) : NULL;
  $address = isset($_POST['address']) ? trim($_POST['address']) : NULL;
  $subject = isset($_POST['tag']) ? trim($_POST['tag']) : NULL;

}

?>
