<?php
defined('_BASE_PATH') ?: header('location: ../../index.php');

// Confirm Email
if (isset($selector) && isset($token)){
  try {
    $auth->confirmEmail($selector, $token);
    if ($auth->isLoggedIn()) {
      try {
        $auth->logOutEverywhere();
      }
      catch (\Delight\Auth\NotLoggedInException $e) {
        \Ivy\Message::add('Not logged in');
      }
    }
    \Ivy\Message::add('Email address has been verified',_BASE_PATH . 'admin/login');
  }
  catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
    \Ivy\Message::add('Invalid token');
  }
  catch (\Delight\Auth\TokenExpiredException $e) {
    \Ivy\Message::add('Token expired');
  }
  catch (\Delight\Auth\UserAlreadyExistsException $e) {
    \Ivy\Message::add('Email address already exists');
  }
  catch (\Delight\Auth\TooManyRequestsException $e) {
    \Ivy\Message::add('Too many requests');
  }
}
