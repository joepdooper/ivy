<?php

global $auth;

use Delight\Auth\InvalidSelectorTokenPairException;
use Delight\Auth\TokenExpiredException;
use Delight\Auth\ResetDisabledException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\AuthError;
use Ivy\Message;

// Confirm Email
if (isset($selector) && isset($token)) {
    try {
        $auth->canResetPasswordOrThrow($selector, $token);
        Message::add('Create a new secure password');
    } catch (InvalidSelectorTokenPairException $e) {
        Message::add('Invalid token');
    } catch (TokenExpiredException $e) {
        Message::add('Token expired');
    } catch (ResetDisabledException $e) {
        Message::add('Password reset is disabled');
    } catch (TooManyRequestsException $e) {
        Message::add('Too many requests');
    } catch (AuthError) {
        Message::add('Auth error');
    }
}
