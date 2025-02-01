<?php

use Ivy\App;
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
    App::router()->get('/login', function () {
        Template::view('admin/login.latte');
    });
    App::router()->get('/logout', function () {
        Template::view('admin/logout.latte');
    });
    App::router()->get('/reset', function () {
        Template::view('admin/reset.latte');
    });
    if (User::isLoggedIn()):
        App::router()->get('/profile', function () {
            $profile = (new Profile)->where('user_id', $_SESSION['auth_user_id'])->fetchOne();
            Template::view('admin/profile.latte', ['profile' => $profile]);
        });
    endif;
    if (User::isLoggedIn() && User::canEditAsAdmin()):
        App::router()->get('/plugin', function () {
            // -- Installed plugins from database
            $installed_plugins = (new Plugin)->where('parent_id', null)->fetchAll();
            // -- Uninstalled plugins from directory
            $values_to_remove_from_uninstalled_plugins = ['.', '..', '.DS_Store'];
            foreach ($installed_plugins as $plugin) {
                $plugin->setInfo();
                $values_to_remove_from_uninstalled_plugins[] = $plugin->getUrl();
            }
            $uninstalled_plugins = array_filter(scandir(_PUBLIC_PATH . _PLUGIN_PATH), function ($plugin) use ($values_to_remove_from_uninstalled_plugins) {
                return !in_array($plugin, $values_to_remove_from_uninstalled_plugins);
            });
            $uninstalled_plugins_info = [];
            foreach ($uninstalled_plugins as $key => $plugin) {
                $uninstalled_plugins_info[$key] = json_decode(file_get_contents(_PUBLIC_PATH . _PLUGIN_PATH . $plugin . '/info.json'));
                $uninstalled_plugins_info[$key]->url = $plugin;
            }
            $uninstalled_plugins = $uninstalled_plugins_info;
            Template::view('admin/plugin.latte', ['installed_plugins' => $installed_plugins, 'uninstalled_plugins' => $uninstalled_plugins]);
        });
        App::router()->get('/template', function () {
            Template::view('admin/template.latte');
        });
        App::router()->get('/user', function () {
            $users = (new User)->addJoin('profiles', 'id', '=', 'user_id')->fetchAll();
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