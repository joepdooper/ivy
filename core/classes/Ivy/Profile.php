<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

class Profile {

  public $user_id, $username, $roles, $image, $last_login;

  public function __construct($user_id = null) {

    $user_id = !$user_id ? $_SESSION['auth_user_id'] : $user_id;

    global $db;
    $profile = $db->selectRow(
      '
      SELECT `profiles`.`user_id`, `profiles`.`users_image`, `users`.`email`, `users`.`username`, `users`.`status`, `users`.`roles_mask`, `users`.`last_login` FROM `profiles`
      INNER JOIN `users` ON `users`.`id` = `profiles`.`user_id`
      WHERE `user_id` = :user_id
      ', [$user_id]
    );

    $this->user_id = $user_id;
    $this->username = $profile ? $profile['username'] : '';
    $this->roles = $profile ? $profile['roles_mask'] : '';
    $this->image = $profile ? $profile['users_image'] : '';

    $seconds_ago = $profile ? (time() - $profile['last_login']) : '';

    if ($seconds_ago >= 31536000) {
      $this->last_login = "seen " . intval($seconds_ago / 31536000) . " years ago";
    } elseif ($seconds_ago >= 2419200) {
      $this->last_login = "seen " . intval($seconds_ago / 2419200) . " months ago";
    } elseif ($seconds_ago >= 86400) {
      $this->last_login = "seen " . intval($seconds_ago / 86400) . " days ago";
    } elseif ($seconds_ago >= 3600) {
      $this->last_login = "seen " . intval($seconds_ago / 3600) . " hours ago";
    } elseif ($seconds_ago >= 60) {
      $this->last_login = "seen " . intval($seconds_ago / 60) . " minutes ago";
    } else {
      $this->last_login = "seen less than a minute ago";
    }

  }

  function post() {

    global $db, $auth;

    if($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isLoggedIn()){

      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      try {

        $name = trim($purifier->purify($_POST['name']));
        $email = trim($purifier->purify($_POST['email']));

        if(empty($name)){
          Message::add('Please enter name');
        }
        if(empty($email)){
          Message::add('Please enter email');
        }

        if(!empty($name) && !empty($email)){

          if(isset($_POST['userimage']) && $_POST['userimage'] == 'delete'){
            (new Image)->delete($this->image);
            $db->update('profiles',['users_image' => ''],['user_id' => $_SESSION['auth_user_id']]);
          }

          if($_FILES){
            $db->update(
              'profiles',
              ['users_image' => (new Image)->upload($_FILES['userimage'])],
              ['user_id' => $_SESSION['auth_user_id']]
            );
          }

          if($auth->getUsername() != $name){
            $db->update('users',['username' => $name],['id' => $_SESSION['auth_user_id']]);
            $_SESSION[\Delight\Auth\UserManager::SESSION_FIELD_USERNAME] = $name;
          }

          if($_SESSION['auth_email'] != $email) {
            try {
              if ($auth->reconfirmPassword($_POST['password'])) {
                $auth->changeEmail($_POST['newEmail'], function ($selector, $token) {
                  echo 'Send ' . $selector . ' and ' . $token . ' to the user (e.g. via email to the *new* address)';
                });

                echo 'The change will take effect as soon as the new email address has been confirmed';
              }
              else {
                echo 'We can\'t say if the user is who they claim to be';
              }
            }
            catch (\Delight\Auth\InvalidEmailException $e) {
              die('Invalid email address');
            }
            catch (\Delight\Auth\UserAlreadyExistsException $e) {
              die('Email address already exists');
            }
            catch (\Delight\Auth\EmailNotVerifiedException $e) {
              die('Account not verified');
            }
            catch (\Delight\Auth\NotLoggedInException $e) {
              die('Not logged in');
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
              die('Too many requests');
            }

          }
          Message::add('Update succesfully',_BASE_PATH . 'admin/profile');
        }
      } catch (Exception $e) {
        Message::add('Something went wrong',_BASE_PATH . 'admin/profile');
      }
    }

  }

}
?>
