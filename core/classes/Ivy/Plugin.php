<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

#[\AllowDynamicProperties]

class Plugin extends Model {
    use Cache;

    protected $table = 'plugin';
    protected $path = _BASE_PATH . 'admin/plugin';
    public array $actives;
    public \stdClass $plugin;

    public function run(): void
    {
        $plugins = $this->get()->data();
        if ($plugins) {
            foreach ($plugins as $plugin) {
                if ($plugin->active == '1') {
                    $this->actives[] = $plugin->name;
                }
            }
            $_SESSION['plugin_actives'] = $this->actives;
            foreach ($plugins as $plugin) {
                if ($plugin->active == '1') {
                    $this->includeHooks($plugin);
                }
            }
        }
    }

    public function includeHooks($plugin): void
    {
        global $auth;

        $this->plugin = $plugin;

        if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . 'hooks/hook.basic.php')) {
            include _PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . 'hooks/hook.basic.php';
        }
        if($auth->isLoggedIn()){
            if(canEditAsEditor($auth)){
                if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . 'hooks/hook.editor.php')) {
                    include _PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . 'hooks/hook.editor.php';
                }
            }
            if(canEditAsAdmin($auth)){
                if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . 'hooks/hook.admin.php')) {
                    include _PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . 'hooks/hook.admin.php';
                }
            }
        }
    }

    function post(): void
    {
        global $db;

        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        $plugins = $_POST['plugin'] ?? '';

        foreach ($plugins as $key => $plugin) {

            if(!isset($plugin['id'])) {
                $info = json_decode(file_get_contents(_PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . '/info.json'));
                if (isset($info->dependencies) && !empty($missing = $this->checkDependencies((array)$info->dependencies))) {
                    $count = count($missing);
                    $message = "This plugin has " . ($count > 1 ? "dependencies" : "dependency") . ". Please install the " . ($count > 1 ? "plugins" : "plugin") . " " . implode(", ", $missing);
                    Message::add($message, _BASE_PATH . 'admin/plugin');
                }
                $_POST['plugin'][$key] = [
                    'name' => $purifier->purify($info->name),
                    'version' => $purifier->purify($info->version),
                    'desc' => $purifier->purify($info->description),
                    'url' => $purifier->purify($info->url),
                    'type' => $purifier->purify($info->type),
                    'settings' => (!empty($info->settings) ? '1' : '0')
                ];
                if(!empty($info->database->install)) {
                    if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $info->url . DIRECTORY_SEPARATOR . $info->database->install)) {
                        require_once _PUBLIC_PATH . _PLUGIN_PATH . $info->url . DIRECTORY_SEPARATOR . $info->database->install;
                    }
                }
            }

            if(isset($plugin['delete'])) {
                $plugin['url'] = $db->selectValue(
                    'SELECT url FROM plugin WHERE id = :id',
                    [
                        $plugin['id']
                    ]
                );
                $info = json_decode(file_get_contents(_PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . '/info.json'));
                if(!empty($info->database->uninstall)) {
                    if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $info->url . DIRECTORY_SEPARATOR . $info->database->uninstall)) {
                        require_once _PUBLIC_PATH . _PLUGIN_PATH . $info->url . DIRECTORY_SEPARATOR . $info->database->uninstall;
                    }
                }
            }

        }

        parent::post();
    }

    // -- function to check dependencies
    private function checkDependencies($dependencies): array
    {
        global $db;

        return array_filter($dependencies, function ($dependency) use ($db) {
            // -- check if the dependent plugin is installed
            return !$db->selectValue('SELECT id FROM plugin WHERE name = :name', ['name' => $dependency]);
        });
    }

}
