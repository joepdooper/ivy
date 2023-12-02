<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
// Confirm Email
if (isset($_GET['selector']) && isset($_GET['token'])){
  try {
      $auth->confirmEmail($_GET['selector'], $_GET['token']);
      \Ivy\Message::add('Email address has been verified');
  }
  catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    \Ivy\Message::add('Invalid token');
      // die('Invalid token');
  }
  catch (\Delight\Auth\TokenExpiredException $e) {
    \Ivy\Message::add('Token expired');
      // die('Token expired');
  }
  catch (\Delight\Auth\UserAlreadyExistsException $e) {
    \Ivy\Message::add('Email address already exists');
      // die('Email address already exists');
  }
  catch (\Delight\Auth\TooManyRequestsException $e) {
    \Ivy\Message::add('Too many requests');
      // die('Too many requests');
  }
}
?>