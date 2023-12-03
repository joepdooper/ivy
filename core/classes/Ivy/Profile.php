<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

class Profile extends Model {

  protected $table = 'profiles';
  protected $path = _BASE_PATH . 'admin/profile';

  public $id, $user_id, $username, $roles, $users_image, $last_login;

  public function __construct() {
    $this->query = "
    SELECT `profiles`.`id`, `profiles`.`user_id`, `profiles`.`users_image`, `users`.`email`, `users`.`username`, `users`.`status`, `users`.`roles_mask`, `users`.`last_login` FROM `profiles`
    INNER JOIN `users` ON `users`.`id` = `profiles`.`user_id`
    ";
  }

  public function post() {
    global $auth, $db;

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isLoggedIn()) {

      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      try {

        $name = $purifier->purify($_POST['users']['username']);
        $email = $purifier->purify($_POST['users']['email']);

        if(!empty($name) && !empty($email)){

          if($auth->getUsername() != $name){
            $this->table = 'users';
            $this->save(['id' => $auth->getUserId(),'username' => $name]);
            $_SESSION[\Delight\Auth\UserManager::SESSION_FIELD_USERNAME] = $name;
          }

          if($auth->getEmail() != $email) {
            try {
              $auth->changeEmail($_POST['users']['email'], function ($selector, $token) use ($purifier)  {
                $url = _BASE_PATH . 'admin/profile/' . \urlencode($selector) . '/' . \urlencode($token);
                // send email
                $mail = new Mail();
                $mail->Address = $purifier->purify($email);
                $mail->Name    = $purifier->purify($name);
                $mail->Subject = 'Reset email address';
                $mail->Body    = 'Reset your email address with this link: ' . $url;
                $mail->AltBody = 'Reset your email address with this link: ' . $url;
                $mail->send();
              });
              Message::add('The change will take effect as soon as the new email address has been confirmed');
            }
            catch (\Delight\Auth\InvalidEmailException $e) {
              Message::add('Invalid email address');
            }
            catch (\Delight\Auth\UserAlreadyExistsException $e) {
              Message::add('Email address already exists');
            }
            catch (\Delight\Auth\EmailNotVerifiedException $e) {
              Message::add('Account not verified');
            }
            catch (\Delight\Auth\NotLoggedInException $e) {
              Message::add('Not logged in');
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
              Message::add('Too many requests');
            }
          }

          if(isset($_POST['users_image']) && $_POST['users_image'] == 'delete'){
            $this->table = 'profiles';
            $this->save(['id' => $this->id,'user_id' => $auth->getUserId(),'users_image' => '']);
            (new \Image)->delete($this->users_image);
          }

          if($_FILES){
            $this->table = 'profiles';
            $db->update(
              'profiles',
              ['users_image' => (new \Image)->upload($_FILES['users_image'])],
              ['user_id' => $_SESSION['auth_user_id']]
            );
          }

          $message = 'Update succesfully';
        } else {
          if(empty($email)){
            $message = 'Please enter email';
          }
          if(empty($name)){
            $message = 'Please enter name';
          }
        }
      } catch (Exception $e) {
        $message = 'Something went wrong';
      }

      Message::add($message, $this->path);

      // Call the parent post method from the Model class
      // parent::post();
    }
  }

}
?>
