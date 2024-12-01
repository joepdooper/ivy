<?php

use Ivy\Plugin;
use Ivy\Profile;
use Ivy\Setting;
use Ivy\Template;
use Ivy\User;

global $router;

// -- ADMIN

$router->mount('/admin', function () use ($router) {
    $router->get('/profile', function () {
        $profile = (new \Ivy\Profile)->where('user_id', $_SESSION['auth_user_id'])->getRow()->single();
        Template::view('admin/profile.latte', ['profile' => $profile]);
    });
    $router->get('/register', function () {
        Template::view('admin/register.latte');
    });
    $router->get('/login', function () {
        Template::view('admin/login.latte');
    });
    $router->get('/logout', function () {
        Template::view('admin/logout.latte');
    });
    $router->get('/reset', function () {
        Template::view('admin/reset.latte');
    });
    if (User::canEditAsAdmin()):
        $router->get('/plugin', function () {
            // -- Installed plugins from database
            $installed_plugins = (new Plugin)->get()->all();
            // -- Uninstalled plugins from directory
            $values_to_remove_from_uninstalled_plugins = ['.', '..', '.DS_Store'];
            foreach ($installed_plugins as $plugin) {
                $values_to_remove_from_uninstalled_plugins[] = $plugin->url;
            }
            $uninstalled_plugins = array_filter(scandir(_PUBLIC_PATH . _PLUGIN_PATH), function ($plugin) use ($values_to_remove_from_uninstalled_plugins) {
                return !in_array($plugin, $values_to_remove_from_uninstalled_plugins);
            });
            $uninstalled_plugins_info = [];
            foreach ($uninstalled_plugins as $plugin) {
                $uninstalled_plugins_info[] = json_decode(file_get_contents(_PUBLIC_PATH . _PLUGIN_PATH . $plugin . '/info.json'));
            }
            $uninstalled_plugins = $uninstalled_plugins_info;
            Template::view('admin/plugin.latte', ['installed_plugins' => $installed_plugins, 'uninstalled_plugins' => $uninstalled_plugins]);
        });
        $router->get('/template', function () {
            Template::view('admin/template.latte');
        });
        $router->get('/user', function () {
            $users = (new User)->get()->all();
            Template::view('admin/user.latte', ['users' => $users]);
        });
        $router->get('/setting', function () {
            $settings = (new Setting)->get()->all();
            Template::view('admin/setting.latte', ['settings' => $settings]);
        });
    endif;
});

// -- PROFILE

$router->get('/profile/(\d+)', function ($id) {
    $profile = (new Profile)->where('id', $id)->getRow()->single();
    Template::view('include/profile.latte', ['profile' => $profile]);
});