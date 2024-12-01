<?php

namespace Ivy;

use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;
use Exception;
use HTMLPurifier;
use HTMLPurifier_Config;
use Image\Image;
use function urlencode;

class Profile extends Model
{

    protected string $table = 'profiles';
    protected string $path = _BASE_PATH . 'admin/profile';

    public int $id;
    public int $user_id;
    public string $username;

    public function __construct()
    {
        parent::__construct();
        $this->query = "
    SELECT `profiles`.`id`, `profiles`.`user_id`, `profiles`.`users_image`, `users`.`email`, `users`.`username`, `users`.`status`, `users`.`roles_mask`, `users`.`last_login` FROM `profiles`
    INNER JOIN `users` ON `users`.`id` = `profiles`.`user_id`
    ";
    }

    public function post(Request $request = null): void
    {
        $request = $request ?? new Request();

        if ($request->isMethod('POST') && User::isLoggedIn()) {

            $config = HTMLPurifier_Config::createDefault();
            $purifier = new HTMLPurifier($config);

            $message = 'post profile';

            try {

                $name = $purifier->purify($request->input('users')['username']);
                $email = $purifier->purify($request->input('users')['email']);
                if (!empty($name) && !empty($email)) {

                    if (User::getUsername() != $name) {
                        $this->table = 'users';
                        $this->where('id', User::getUserId())->getRow();
                        $this->save([
                            'id' => User::getUserId(),
                            'username' => $name
                        ]);
                    }

                    if (User::getEmail() != $email) {
                        try {
                            User::changeEmail($purifier->purify($request->input('users')['email']), function ($selector, $token) use ($purifier, $request) {
                                $url = _BASE_PATH . 'admin/profile/' . urlencode($selector) . '/' . urlencode($token);
                                // send email
                                $mail = new Mail();
                                $mail->Address = $purifier->purify($request->input('users')['email']);
                                $mail->Name = $purifier->purify($request->input('users')['username']);
                                $mail->Subject = 'Reset email address';
                                $mail->Body = 'Reset your email address with this link: ' . $url;
                                $mail->AltBody = 'Reset your email address with this link: ' . $url;
                                $mail->send();
                            });
                            Message::add('An email has been sent to ' . $email . ' with a link to confirm the email address');
                        } catch (InvalidEmailException) {
                            Message::add('Invalid email address');
                        } catch (UserAlreadyExistsException) {
                            Message::add('Email address already exists');
                        } catch (EmailNotVerifiedException) {
                            Message::add('Account not verified');
                        } catch (NotLoggedInException) {
                            Message::add('Not logged in');
                        } catch (TooManyRequestsException) {
                            Message::add('Too many requests');
                        }
                    }

                    if ($request->input('users_image') !== null && $request->input('users_image') === 'delete') {
                        $this->table = 'profiles';
                        $this->where('user_id', User::getUserId())->getRow();
                        $this->save([
                            'id' => $this->single()->id,
                            'users_image' => ''
                        ]);
                        (new Image)->delete_set($this->single()->users_image);
                    }

                    if ($request->input('users_image')['tmp_name']) {
                        $this->table = 'profiles';
                        $this->where('user_id', User::getUserId())->getRow();
                        $this->save([
                            'id' => $this->single()->id,
                            'users_image' => (new Image)->upload($request->input('users_image'))
                        ]);
                    }

                    $message = 'Update successfully';
                } else {
                    if (empty($email)) {
                        $message = 'Please enter email';
                    }
                    if (empty($name)) {
                        $message = 'Please enter name';
                    }
                }
            } catch (Exception) {
                $message = 'Something went wrong';
            }

            Message::add($message, $this->path);

        }
    }

    public static function lastSeen($last_login): string
    {
        $seconds_ago = time() - $last_login;
        if ($seconds_ago >= 31536000) {
            $value = "seen " . intval($seconds_ago / 31536000) . " years ago";
        } elseif ($seconds_ago >= 2419200) {
            $value = "seen " . intval($seconds_ago / 2419200) . " months ago";
        } elseif ($seconds_ago >= 86400) {
            $value = "seen " . intval($seconds_ago / 86400) . " days ago";
        } elseif ($seconds_ago >= 3600) {
            $value = "seen " . intval($seconds_ago / 3600) . " hours ago";
        } elseif ($seconds_ago >= 60) {
            $value = "seen " . intval($seconds_ago / 60) . " minutes ago";
        } else {
            $value = "seen less than a minute ago";
        }
        return $value;
    }

}
