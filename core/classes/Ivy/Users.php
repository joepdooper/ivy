<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

class Users extends Model {

  protected $table = 'users';
  protected $path = _BASE_PATH . 'admin/user';

  function post() {

    global $auth;

    if($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isLoggedIn()){

      try {

        $users = isset($_POST['users']) ? $_POST['users'] : '';
        $delete = isset($_POST['delete']) ? $_POST['delete'] : '';

        // Update users
        if(!empty($users)){
          foreach($users as $key => $row){
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

        // Delete users
        if(!empty($delete) && !$auth->admin()->doesUserHaveRole($delete, \Delight\Auth\Role::SUPER_ADMIN)){
          try {
            $auth->admin()->deleteUserById($delete);
          }
          catch (\Delight\Auth\UnknownIdException $e) {
            die('Unknown ID');
          }
        }

        \Ivy\Message::add('Update succesfully',_BASE_PATH . 'admin/users');
      } catch (Exception $e) {
        \Ivy\Message::add('Something went wrong',_BASE_PATH . 'admin/users');
      }

    }

  }

}
?>
