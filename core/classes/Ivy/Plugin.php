<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

#[\AllowDynamicProperties]

class Plugin extends Model {

  protected $table = 'plugin';
  protected $path = _BASE_PATH . 'admin/plugin';
  public $plugin;

  private static function return_plugin_file_path($plugin, $file) {
    return _PUBLIC_PATH . _PLUGIN_PATH . $plugin->url . DIRECTORY_SEPARATOR . $file;
  }

  public static function load($plugin) {
    global $auth, $hooks;
    $hook_file_basic = self::return_plugin_file_path($plugin, 'hooks/hook.add_action.php');
    if (file_exists($hook_file_basic)) {
      include $hook_file_basic;
    }
    if($auth->isLoggedIn()){
      if(canEditAsEditor($auth)){
        $hook_file_editor = self::return_plugin_file_path($plugin, 'hooks/hook.editor.php');
        if (file_exists($hook_file_editor)) {
          include $hook_file_editor;
        }
      }
      if(canEditAsAdmin($auth)){
        $hook_file_admin = self::return_plugin_file_path($plugin, 'hooks/hook.admin.php');
        if (file_exists($hook_file_admin)) {
          include $hook_file_admin;
        }
      }
    }
  }

  function post() {
    global $db, $auth;

    if($_SERVER['REQUEST_METHOD'] === 'POST' && $auth->isLoggedIn()){

      $config = HTMLPurifier_Config::createDefault();
      $purifier = new HTMLPurifier($config);

      try {

        $plugins = isset($_POST['plugin']) ? $_POST['plugin'] : '';
        $plugout = isset($_POST['plugout']) ? $_POST['plugout'] : '';
        $deletes = isset($_POST['delete']) ? $_POST['delete'] : '';

        $plugin = new Plugin;

        // -- install plugin
        if(!empty($plugout)){
          $setting = simplexml_load_file(_PUBLIC_PATH . _PLUGIN_PATH . $plugout . '/info.xml');

          // -- check dependencies
          if (isset($setting->dependencies) && !empty($missing = $this->checkDependencies((array)$setting->dependencies->dependency))) {
            $count = count($missing);
            $message = "This plugin has " . ($count > 1 ? "dependencies" : "dependency") . ". Please install the " . ($count > 1 ? "plugins" : "plugin") . " " . implode(", ", $missing);
            Message::add($message, _BASE_PATH . 'admin/plugin');
          }

          $plugin->insert([
            'name' => $setting->name,
            'version' => $setting->version,
            'desc' => $setting->description,
            'url' => $setting->url,
            'type' => $setting->type,
            // 'image' => $setting->image
            'settings' => (!empty($setting->settings) ? '1' : '0')
          ]);

          // -- install plugin database
          if(!empty($setting->database->install)) {
            $database_installer_file = self::return_plugin_file_path($setting->url, $setting->database->install);
            if (file_exists($database_installer_file )) {
              require_once $database_installer_file ;
            }
          }
        }

        // -- deinstall plugin
        if(!empty($deletes)){
          foreach ($deletes as $key => $value) {
            $url = $db->selectValue(
              'SELECT url FROM plugin WHERE id = :id',
              [
                $value
              ]
            );
            $db->delete(
              'plugin',
              [
                // where
                'id' => $value
              ]
            );
            // -- remove plugin database
            $setting = simplexml_load_file(_PUBLIC_PATH . _PLUGIN_PATH . $url . '/info.xml');
            if(!empty($setting->database->uninstall)) {
              $database_installer_file = self::return_plugin_file_path($setting->url, $setting->database->uninstall);
              if (file_exists($database_installer_file )) {
                require_once $database_installer_file ;
              }
            }
          }
        }

        // (de)activate plugin
        if(!empty($plugins)){
          foreach ($plugins as $key => $value) {
            $db->update(
              'plugin',
              [
                // set
                'active' => $value
              ],
              [
                // where
                'id' => $key
              ]
            );
          }
        }

        Message::add('Update succesfully',_BASE_PATH . 'admin/plugin');
      } catch (Exception $e) {
        Message::add('Something went wrong',_BASE_PATH . 'admin/plugin');
      }

    }

  }

  // -- function to check dependencies
  private function checkDependencies($dependencies) {
    global $db;

    $missing = array_filter($dependencies, function ($dependency) use ($db) {
      // -- check if the dependent plugin is installed
      return !$db->selectValue('SELECT id FROM plugin WHERE name = :name', ['name' => $dependency]);
    });

    return $missing;
  }

}
?>
