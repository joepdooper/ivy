<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Message;

// Confirm Email
if (isset($selector) && isset($token)){
  try {
    $auth->canResetPasswordOrThrow($selector, $token);
    Message::add('Create a new secure password');
  }
  catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    Message::add('Invalid token');
  }
  catch (\Delight\Auth\TokenExpiredException $e) {
    Message::add('Token expired');
  }
  catch (\Delight\Auth\ResetDisabledException $e) {
    Message::add('Password reset is disabled');
  }
  catch (\Delight\Auth\TooManyRequestsException $e) {
    Message::add('Too many requests');
  }
}
