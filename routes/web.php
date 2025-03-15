<?php

use Delight\Auth\AuthError;
use Delight\Auth\InvalidSelectorTokenPairException;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\ResetDisabledException;
use Delight\Auth\TokenExpiredException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;
use Ivy\App;
use Ivy\Message;
use Ivy\Path;
use Ivy\Plugin;
use Ivy\Profile;
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

// -- ADMIN

App::router()->mount('/admin', function () {
    App::router()->get('/register', function () {
        Template::view('admin/register.latte');
    });
    App::router()->get('/login(/[^/]+)?(/[^/]+)?', function ($selector = null, $token = null) {
        if (isset($selector) && isset($token)) {
            try {
                if (User::getAuth()->isLoggedIn()) {
                    try {
                        User::getAuth()->logOutEverywhere();
                    } catch (NotLoggedInException) {
                        Message::add('Not logged in');
                    }
                }
                User::getAuth()->confirmEmail($selector, $token);
                Message::add('Email address has been verified', Path::get('BASE_PATH') . 'admin/login');
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
        Template::view('admin/login.latte');
    });
    App::router()->get('/logout', function () {
        Template::view('admin/logout.latte');
    });
    App::router()->get('/reset(/[^/]+)?(/[^/]+)?', function ($selector = null, $token = null) {
        if (isset($selector) && isset($token)) {
            try {
                User::getAuth()->canResetPasswordOrThrow($selector, $token);
                Message::add('Create a new secure password');
            } catch (InvalidSelectorTokenPairException $e) {
                Message::add('Invalid token', Path::get('BASE_PATH') . 'admin/reset');
            } catch (TokenExpiredException $e) {
                Message::add('Token expired', Path::get('BASE_PATH') . 'admin/reset');
            } catch (ResetDisabledException $e) {
                Message::add('Password reset is disabled', Path::get('BASE_PATH') . 'admin/reset');
            } catch (TooManyRequestsException $e) {
                Message::add('Too many requests', Path::get('BASE_PATH') . 'admin/reset');
            } catch (AuthError) {
                Message::add('Auth error', Path::get('BASE_PATH') . 'admin/reset');
            }
        }
        Template::view('admin/reset.latte', ['selector' => $selector, 'token' => $token]);
    });
    if (User::getAuth()->isLoggedIn()):
        App::router()->get('/profile', function () {
            $profile = (new Profile)->where('user_id', $_SESSION['auth_user_id'])->fetchOne();
            Template::view('admin/profile.latte', ['profile' => $profile]);
        });
    endif;
    if (User::getAuth()->isLoggedIn() && User::canEditAsAdmin()):
        App::router()->get('/plugin(/[a-z0-9_-]+)?(/collection)?', function ($id) {
            if($id) {
                $parent_id = (new Plugin)->where('url', $id)->fetchOne()->getId();
                $uninstalled_plugins = null;
            } else {
                $parent_id = null;
            }
            // -- Installed plugins from database
            $installed_plugins = (new Plugin)->where('parent_id', $parent_id)->fetchAll();
            // -- Uninstalled plugins from directory
            $values_to_remove_from_uninstalled_plugins = ['.', '..', '.DS_Store'];
            foreach ($installed_plugins as $plugin) {
                $plugin->setInfo();
                $values_to_remove_from_uninstalled_plugins[] = $plugin->url;
            }
            if(!$id) {
                $uninstalled_plugins = array_filter(scandir(Path::get('PUBLIC_PATH') . Path::get('PLUGIN_PATH')), function ($plugin) use ($values_to_remove_from_uninstalled_plugins) {
                    return !in_array($plugin, $values_to_remove_from_uninstalled_plugins);
                });
                $uninstalled_plugins_info = [];
                foreach ($uninstalled_plugins as $key => $plugin) {
                    $uninstalled_plugins_info[$key] = json_decode(file_get_contents(Path::get('PUBLIC_PATH') . Path::get('PLUGIN_PATH') . $plugin . '/info.json'));
                    $uninstalled_plugins_info[$key]->url = $plugin;
                }
                $uninstalled_plugins = $uninstalled_plugins_info;
            }
            Template::view('admin/plugin.latte', ['installed_plugins' => $installed_plugins, 'uninstalled_plugins' => $uninstalled_plugins]);
        });
        App::router()->get('/template', function () {
            Template::view('admin/template.latte');
        });
        App::router()->get('/user', function () {
            $users = (new User)->fetchAll();
            Template::view('admin/user.latte', ['users' => $users]);
        });
        App::router()->get('/setting', function () {
            $settings = (new Setting)->fetchAll();
            Template::view('admin/setting.latte', ['settings' => $settings]);
        });
    endif;
});

// -- PROFILE

App::router()->get('/profile/(\d+)', function ($id) {
    $profile = (new Profile)->where('id', $id)->fetchOne();
    Template::view('include/profile.latte', ['profile' => $profile]);
});