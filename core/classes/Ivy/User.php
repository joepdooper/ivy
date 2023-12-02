<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

class User {

  // Register

  function register() {

    global $db, $auth;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      try {
        $userId = $auth->register($purifier->purify($_POST['email']), $purifier->purify($_POST['password']), $purifier->purify($_POST['username']), function ($selector, $token) use ($purifier) {
          $url = _BASE_PATH . 'admin/login/' . \urlencode($selector) . '/' . \urlencode($token);
          // send email
          $mail = new \Ivy\Mail();
          $mail->Address = $purifier->purify($_POST['email']);
          $mail->Name    = $purifier->purify($_POST['username']);
          $mail->Subject = 'Activate account';
          $mail->Body    = 'Activate your account with this link: ' . $url;
          $mail->AltBody = 'Activate your account with this link: ' . $url;
          $mail->send();
        });
      }
      catch (\Delight\Auth\InvalidEmailException $e) {
        \Ivy\Message::add('Invalid email address', _BASE_PATH . 'admin/register');
        // die('Invalid email address');
      }
      catch (\Delight\Auth\InvalidPasswordException $e) {
        \Ivy\Message::add('Invalid password', _BASE_PATH . 'admin/register');
        // die('Invalid password');
      }
      catch (\Delight\Auth\UserAlreadyExistsException $e) {
        \Ivy\Message::add('User already exists', _BASE_PATH . 'admin/register');
        // die('User already exists');
      }
      catch (\Delight\Auth\TooManyRequestsException $e) {
        \Ivy\Message::add('Too many requests', _BASE_PATH . 'admin/register');
        // die('Too many requests');
      }

      $db->insert('profiles',['user_id' => $userId]);

      Message::add('An email to ' . $_POST['email'] . ' has been sent with a link to activate your account', _BASE_PATH . 'admin/login');

    }

  }

  // Login

  function login() {

    global $auth;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      try {
        $auth->login($purifier->purify($_POST['email']), $purifier->purify($_POST['password']));
        \Ivy\Message::add('Welcome ' . $auth->getUsername(), _BASE_PATH . 'admin/profile');
      }
      catch (\Delight\Auth\InvalidEmailException $e) {
        \Ivy\Message::add('Wrong email address', _BASE_PATH . 'admin/login');
        // die('Wrong email address');
      }
      catch (\Delight\Auth\InvalidPasswordException $e) {
        \Ivy\Message::add('Wrong password', _BASE_PATH . 'admin/login');
        // die('Wrong password');
      }
      catch (\Delight\Auth\EmailNotVerifiedException $e) {
        \Ivy\Message::add('Email not verified', _BASE_PATH . 'admin/login');
        // die('Email not verified');
      }
      catch (\Delight\Auth\TooManyRequestsException $e) {
        \Ivy\Message::add('Too many requests', _BASE_PATH . 'admin/login');
        // die('Too many requests');
      }

    }

  }

  // Logout

  function logout() {

    global $auth, $hooks;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      $hooks->do_action('start_logout_action');

      $auth->logOut();
      $auth->destroySession();

      $hooks->do_action('end_logout_action');

      Message::add('Logout succesfully',_BASE_PATH);

    }

  }

  // Reset

  function reset() {

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      global $auth;

      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      if(isset($_POST['email'])){

        try {
          $auth->forgotPassword($purifier->purify($_POST['email']), function ($selector, $token) {
            $url = _BASE_PATH . 'admin/reset/' . \urlencode($selector) . '/' . \urlencode($token);
            // send email
            $mail = new Mail();
            $mail->Address = $purifier->purify($_POST['email']);
            $mail->Name    = $purifier->purify($_POST['username']);
            $mail->Subject = 'Reset password';
            $mail->Body    = 'Reset password with this link: ' . $url;
            $mail->AltBody = 'Reset password with this link: ' . $url;
            $mail->send();
          });
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
          die('Invalid email address');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
          die('Email not verified');
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
          die('Password reset is disabled');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
          die('Too many requests');
        }

        Message::add('An email to ' . $_POST['email'] . ' has been sent with a link to reset your password', _BASE_PATH . 'admin/reset');

      }

      if(isset($_POST['password'])){
        try {
          $auth->resetPassword($_GET['selector'], $_GET['token'], $_POST['password']);
          Message::add('Password has been reset', _BASE_PATH . 'admin/login');
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
          die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
          die('Token expired');
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
          die('Password reset is disabled');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
          die('Invalid password');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
          die('Too many requests');
        }
      }

    }

  }

}
?>
