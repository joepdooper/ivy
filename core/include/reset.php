<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');

// Confirm Email
if (isset($_GET['selector']) && isset($_GET['token']) ){
  try {
    $auth->canResetPasswordOrThrow($_GET['selector'], $_GET['token']);
    \Ivy\Message::add('Create a new secure password');
  }
  catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    \Ivy\Message::add('Invalid token');
    // die('Invalid token');
  }
  catch (\Delight\Auth\TokenExpiredException $e) {
    \Ivy\Message::add('Token expired');
    // die('Token expired');
  }
  catch (\Delight\Auth\ResetDisabledException $e) {
    \Ivy\Message::add('Password reset is disabled');
    // die('Password reset is disabled');
  }
  catch (\Delight\Auth\TooManyRequestsException $e) {
    \Ivy\Message::add('Too many requests');
    // die('Too many requests');
  }
}
?>
