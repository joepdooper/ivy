<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

class User extends Model {

  protected $table = 'users';
  protected $path = _BASE_PATH . 'admin/user';

  // Register

  function register(): void
  {

    global $db, $auth;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      try {
        $userId = $auth->register($purifier->purify($_POST['email']), $purifier->purify($_POST['password']), $purifier->purify($_POST['username']), function ($selector, $token) use ($purifier) {
          $url = _BASE_PATH . 'admin/login/' . urlencode($selector) . '/' . urlencode($token);
          // send email
          $mail = new Mail();
          $mail->Address = $purifier->purify($_POST['email']);
          $mail->Name    = $purifier->purify($_POST['username']);
          $mail->Subject = 'Activate account';
          $mail->Body    = 'Activate your account with this link: ' . $url;
          $mail->AltBody = 'Activate your account with this link: ' . $url;
          $mail->send();
        });
      }
      catch (\Delight\Auth\InvalidEmailException $e) {
        Message::add('Invalid email address', _BASE_PATH . 'admin/register');
      }
      catch (\Delight\Auth\InvalidPasswordException $e) {
        Message::add('Invalid password', _BASE_PATH . 'admin/register');
      }
      catch (\Delight\Auth\UserAlreadyExistsException $e) {
        Message::add('User already exists', _BASE_PATH . 'admin/register');
      }
      catch (\Delight\Auth\TooManyRequestsException $e) {
        Message::add('Too many requests', _BASE_PATH . 'admin/register');
      }

      $db->insert('profiles',['user_id' => $userId]);

      // Set role to registered user
      if(Setting::$cache['registration_role']->bool && Setting::$cache['registration_role']->value){
        $role = strtoupper(Setting::$cache['registration_role']->value);
        $roleConstant = "\Delight\Auth\Role::$role";
        $auth->admin()->addRoleForUserById($userId, constant($roleConstant));
      }

      Message::add('An email has been sent to ' . $_POST['email'] . ' with a link to activate your account', _BASE_PATH . 'admin/login');

    }

  }

  // Login

  function login(): void
  {

    global $auth;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      try {
        $auth->login($purifier->purify($_POST['email']), $purifier->purify($_POST['password']));
        Message::add('Welcome ' . $auth->getUsername(), _BASE_PATH . 'admin/profile');
      }
      catch (\Delight\Auth\InvalidEmailException $e) {
        Message::add('Wrong email address', _BASE_PATH . 'admin/login');
        // die('Wrong email address');
      }
      catch (\Delight\Auth\InvalidPasswordException $e) {
        Message::add('Wrong password', _BASE_PATH . 'admin/login');
        // die('Wrong password');
      }
      catch (\Delight\Auth\EmailNotVerifiedException $e) {
        Message::add('Email not verified', _BASE_PATH . 'admin/login');
        // die('Email not verified');
      }
      catch (\Delight\Auth\TooManyRequestsException $e) {
        Message::add('Too many requests', _BASE_PATH . 'admin/login');
        // die('Too many requests');
      }

    }

  }

  // Logout

  function logout(): void
  {

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

  function reset(): void
  {

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

      global $auth;

      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      if(isset($_POST['email'])){

        try {
          $auth->forgotPassword($purifier->purify($_POST['email']), function ($selector, $token) use ($purifier) {
            $url = _BASE_PATH . 'admin/reset/' . \urlencode($selector) . '/' . \urlencode($token);
            // send email
            $mail = new Mail();
            $mail->Address = $purifier->purify($_POST['email']);
            $mail->Name    = '';
            $mail->Subject = 'Reset password';
            $mail->Body    = 'Reset password with this link: ' . $url;
            $mail->AltBody = 'Reset password with this link: ' . $url;
            $mail->send();
          });
        }
        catch (\Delight\Auth\InvalidEmailException $e) {
          Message::add('Invalid email address', _BASE_PATH . 'admin/reset');
        }
        catch (\Delight\Auth\EmailNotVerifiedException $e) {
          Message::add('Email not verified', _BASE_PATH . 'admin/reset');
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
          Message::add('Password reset is disabled', _BASE_PATH . 'admin/reset');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
          Message::add('Too many requests', _BASE_PATH . 'admin/reset');
        }

        Message::add('An email has been sent to ' . $_POST['email'] . ' with a link to reset your password', _BASE_PATH . 'admin/reset');

      }

      if(isset($_POST['password'])){
        try {
          $auth->resetPassword($_POST['selector'], $_POST['token'], $_POST['password']);
          Message::add('Password has been reset', _BASE_PATH . 'admin/login');
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
          Message::add('Invalid token', _BASE_PATH . 'admin/reset');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
          Message::add('Token expired', _BASE_PATH . 'admin/reset');
        }
        catch (\Delight\Auth\ResetDisabledException $e) {
          Message::add('Password reset is disabled', _BASE_PATH . 'admin/reset');
        }
        catch (\Delight\Auth\InvalidPasswordException $e) {
          Message::add('Invalid password', _BASE_PATH . 'admin/reset');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
          Message::add('Too many requests', _BASE_PATH . 'admin/reset');
        }
      }

    }

  }

  function post(): void
  {

    global $auth;

    if($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isLoggedIn()){

      try {

        $users = isset($_POST['users']) ? $_POST['users'] : '';

        // Update users
        if(!empty($users)){
          foreach($users as $key => $row){
            if($row['delete']){
              try {
                $auth->admin()->deleteUserById($key);
              }
              catch (\Delight\Auth\UnknownIdException $e) {
                die('Unknown ID');
              }
            } else {
              if($row['editor']){
                $auth->admin()->addRoleForUserById($key, \Delight\Auth\Role::EDITOR);
              } else {
                $auth->admin()->removeRoleForUserById($key, \Delight\Auth\Role::EDITOR);
              }
              if($row['admin']){
                $auth->admin()->addRoleForUserById($key, \Delight\Auth\Role::ADMIN);
              } else {
                $auth->admin()->removeRoleForUserById($key, \Delight\Auth\Role::ADMIN);
              }
              if($row['super_admin']){
                $auth->admin()->addRoleForUserById($key, \Delight\Auth\Role::SUPER_ADMIN);
              } else {
                $auth->admin()->removeRoleForUserById($key, \Delight\Auth\Role::SUPER_ADMIN);
              }
            }
          }
        }

        Message::add('Update succesfully',_BASE_PATH . 'admin/user');
      } catch (Exception $e) {
        Message::add('Something went wrong',_BASE_PATH . 'admin/user');
      }

    }

  }

}
