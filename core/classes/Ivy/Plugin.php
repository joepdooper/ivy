<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

#[\AllowDynamicProperties]

class Plugin extends Model {

  protected $table = 'plugin';
  protected $path = _BASE_PATH . 'admin/plugin';

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
          if (!empty($setting->database->install)) {
            $databaseFilePath = _PUBLIC_PATH . _PLUGIN_PATH . $plugout . '/' . $setting->database->install;
            if (is_file($databaseFilePath) && strpos($databaseFilePath, _PUBLIC_PATH . _PLUGIN_PATH . $plugout . '/') === 0) {
              require_once $databaseFilePath;
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
            empty($setting->database->uninstall) ?: require_once _PUBLIC_PATH . _PLUGIN_PATH . $url . '/' . $setting->database->uninstall;
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
