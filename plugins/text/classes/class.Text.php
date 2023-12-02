<?php
class Text extends Ivy\Model {

  public $id, $text, $token;
  protected $table = "text";

  // set
  public static function set($name,$value,$id = null) {
    global $page;
    include(_PUBLIC_PATH . $page->setTemplateFile(_PLUGIN_PATH . 'text/template/input.TypeText.php'));
  }

}
?>
