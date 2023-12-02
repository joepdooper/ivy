<?php
class Overlay {

  function set($for,$content) {
    global $page;
    $tpl = $content;
    include $page->setTemplateFile(_PLUGIN_PATH . 'mode-overlay/template/checkbox.php');
    include $page->setTemplateFile(_PLUGIN_PATH . 'mode-overlay/template/overlay.php');
  }

  function popup($for,$content,$item = null) {
    global $page;
    $tpl = $page->setTemplateFile('content/popup.php');
    include $page->setTemplateFile(_PLUGIN_PATH . 'mode-overlay/template/checkbox.php');
    include $page->setTemplateFile(_PLUGIN_PATH . 'mode-overlay/template/overlay.php');
  }

}
?>
