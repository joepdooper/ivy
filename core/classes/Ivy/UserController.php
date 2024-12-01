<?php

namespace Ivy;

use Delight\Auth\AuthError;
use Delight\Auth\Role;
use Delight\Auth\UnknownIdException;

class UserController extends Model
{
    protected User $user;

    public function post(Request $request = null): void
    {
        $request = $request ?? new Request();

        if ($request->isMethod('POST') && User::isLoggedIn()) {
            $users = $request->input('user') ?? '';

            foreach ($users as $key => $user_data) {
                $this->user = new User;

                if (isset($user_data['delete'])) {
                    try {
                        $this->user::admin()->deleteUserById($key);
                    } catch (UnknownIdException|AuthError $e) {
                        Message::add('Something went wrong: ' . $e);
                    }
                } else {
                    try {
                        if ($user_data['editor']) {
                            $this->user::admin()->addRoleForUserById($key, Role::EDITOR);
                        } else {
                            $this->user::admin()->removeRoleForUserById($key, Role::EDITOR);
                        }
                        if ($user_data['admin']) {
                            $this->user::admin()->addRoleForUserById($key, Role::ADMIN);
                        } else {
                            $this->user::admin()->removeRoleForUserById($key, Role::ADMIN);
                        }
                        if ($user_data['super_admin']) {
                            $this->user::admin()->addRoleForUserById($key, Role::SUPER_ADMIN);
                        } else {
                            $this->user::admin()->removeRoleForUserById($key, Role::SUPER_ADMIN);
                        }
                    } catch (UnknownIdException) {
                        Message::add('Unknown ID');
                    }
                }
            }

            Message::add('Update successfully', _BASE_PATH . 'admin/user');
        }
    }
}
