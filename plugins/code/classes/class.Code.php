<?php
class Code extends Ivy\Model {

  public $id, $text, $token;
  protected $table = "code";

  public static function set($name,$value,$id = null) {
    global $page;
    include(_PUBLIC_PATH . $page->setTemplateFile(_PLUGIN_PATH . 'code/template/input.TypeCode.php'));
  }

  public function purify($array) {
    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.AllowedElements', array('br', 'ul', 'ol', 'li', 'b', 'i'));
    $purifier = new HTMLPurifier($config);
    foreach ($array as $key => $value) {
      if($value){
        $array[$key] = $purifier->purify($value);
      }
    }
    return $array;
  }

}
?>
