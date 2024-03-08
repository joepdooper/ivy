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
            if(User::canEditAsEditor($auth)){
                if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . 'hooks/hook.editor.php')) {
                    include _PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . 'hooks/hook.editor.php';
                }
            }
            if(User::canEditAsAdmin($auth)){
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

            // -- install plugin
            if(!isset($plugin['id'])) {
                try {

                    $this->plugin = $this->loadPluginInfo($plugin);

                    if (isset($this->plugin->dependencies) && !empty($missing = $this->checkDependencies((array)$this->plugin->dependencies))) {
                        $count = count($missing);
                        $message = "This plugin has " . ($count > 1 ? "dependencies" : "dependency") . ". Please install the " . ($count > 1 ? "plugins" : "plugin") . " " . implode(", ", $missing);
                        Message::add($message, _BASE_PATH . 'admin/plugin');
                    }

                    $_POST['plugin'][$key] = [
                        'name' => $purifier->purify($this->plugin->name),
                        'version' => $purifier->purify($this->plugin->version),
                        'desc' => $purifier->purify($this->plugin->description),
                        'url' => $purifier->purify($this->plugin->url),
                        'type' => $purifier->purify($this->plugin->type),
                        'settings' => (!empty($this->plugin->settings) ? '1' : '0')
                    ];

                    if(!empty($this->plugin->database->install)) {
                        if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . $this->plugin->database->install)) {
                            require_once _PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . $this->plugin->database->install;
                        }
                    }

                } catch (Exception $e) {
                    Message::add("Error installing plugin: " . $e->getMessage());
                }
            }

            // -- deinstall plugin
            if(isset($plugin['delete'])) {
                try {

                    $plugin['url'] = $db->selectValue(
                        'SELECT url FROM plugin WHERE id = :id',
                        [
                            $plugin['id']
                        ]
                    );

                    $this->plugin = $this->loadPluginInfo($plugin);

                    if(!empty($this->plugin->database->uninstall)) {
                        if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . $this->plugin->database->uninstall)) {
                            require_once _PUBLIC_PATH . _PLUGIN_PATH . $this->plugin->url . DIRECTORY_SEPARATOR . $this->plugin->database->uninstall;
                        }
                    }

                } catch (Exception $e) {
                    Message::add("Error deinstalling plugin: " . $e->getMessage());
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

    private function loadPluginInfo($plugin)
    {
        $dir = _PUBLIC_PATH . _PLUGIN_PATH . $plugin['url'] . DIRECTORY_SEPARATOR;

        if (strpos($dir, _PUBLIC_PATH . _PLUGIN_PATH) === 0) {

            $file = "info.json";
            $path = $dir . $file;
            $url = realpath($path);

            if (is_file($url)) {
                if (strpos($url, $dir) === 0) {
                    $content = file_get_contents($url);
                    $plugin = json_decode($content);
                }
            }

        }

        return $plugin;
    }

}
