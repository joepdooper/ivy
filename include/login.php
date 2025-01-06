<?php

use Delight\Auth\NotLoggedInException;
use Delight\Auth\InvalidSelectorTokenPairException;
use Delight\Auth\TokenExpiredException;
use Delight\Auth\UserAlreadyExistsException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\AuthError;
use Ivy\Message;
use Ivy\User;

// Confirm Email
if (isset($selector) && isset($token)) {
    try {
        User::confirmEmail($selector, $token);
        if (User::isLoggedIn()) {
            try {
                User::logOutEverywhere();
            } catch (NotLoggedInException) {
                Message::add('Not logged in');
            }
        }
        Message::add('Email address has been verified', _BASE_PATH . 'admin/login');
    } catch (InvalidSelectorTokenPairException) {
        Message::add('Invalid token');
    } catch (TokenExpiredException) {
        Message::add('Token expired');
    } catch (UserAlreadyExistsException) {
        Message::add('Email address already exists');
    } catch (TooManyRequestsException) {
        Message::add('Too many requests');
    } catch (AuthError) {
        Message::add('Auth error');
    }
}
