<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');
use Ivy\Message;

// Confirm Email
if (isset($selector) && isset($token)){
  try {
    $auth->confirmEmail($selector, $token);
    if ($auth->isLoggedIn()) {
      try {
        $auth->logOutEverywhere();
      }
      catch (\Delight\Auth\NotLoggedInException $e) {
        Message::add('Not logged in');
      }
    }
    Message::add('Email address has been verified',_BASE_PATH . 'admin/login');
  }
  catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    Message::add('Invalid token');
  }
  catch (\Delight\Auth\TokenExpiredException $e) {
    Message::add('Token expired');
  }
  catch (\Delight\Auth\UserAlreadyExistsException $e) {
    Message::add('Email address already exists');
  }
  catch (\Delight\Auth\TooManyRequestsException $e) {
    Message::add('Too many requests');
  }
}
