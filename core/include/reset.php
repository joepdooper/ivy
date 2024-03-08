<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');

// Confirm Email
if (isset($selector) && isset($token)){
  try {
    $auth->canResetPasswordOrThrow($selector, $token);
    \Ivy\Message::add('Create a new secure password');
  }
  catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    \Ivy\Message::add('Invalid token');
  }
  catch (\Delight\Auth\TokenExpiredException $e) {
    \Ivy\Message::add('Token expired');
  }
  catch (\Delight\Auth\ResetDisabledException $e) {
    \Ivy\Message::add('Password reset is disabled');
  }
  catch (\Delight\Auth\TooManyRequestsException $e) {
    \Ivy\Message::add('Too many requests');
  }
}
