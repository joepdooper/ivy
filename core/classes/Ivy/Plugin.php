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

        $plugin = isset($_POST['plugin']) ? $_POST['plugin'] : '';
        $plugout = isset($_POST['plugout']) ? $_POST['plugout'] : '';
        $delete = isset($_POST['delete']) ? $_POST['delete'] : '';

        // -- install plugin
        if(!empty($plugout)){
          $info = simplexml_load_file(_PUBLIC_PATH . _PLUGIN_PATH . $plugout . '/info.xml');
          $db->insert(
            'plugin',
            [
              // -- set
              'name' => $info->name,
              'version' => $info->version,
              'desc' => $info->description,
              'folder' => $info->url,
              'type' => $info->type,
              // 'image' => $info->image
              'settings' => (!empty($info->settings) ? '1' : '0')
            ]
          );
          // -- install plugin database
          empty($info->database->install) ?: require_once _PUBLIC_PATH . _PLUGIN_PATH . $plugout . '/' . $info->database->install;
        }

        // -- deinstall plugin
        if(!empty($delete)){
          foreach ($delete as $key => $value) {
            $folder = $db->selectValue(
              'SELECT folder FROM plugin WHERE id = :id',
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
            $info = simplexml_load_file(_PUBLIC_PATH . _PLUGIN_PATH . $folder . '/info.xml');
            empty($info->database->uninstall) ?: require_once _PUBLIC_PATH . _PLUGIN_PATH . $folder . '/' . $info->database->uninstall;
          }
        }

        // (de)activate plugin
        if(!empty($plugin)){
          foreach ($plugin as $key => $value) {
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

}
?>
