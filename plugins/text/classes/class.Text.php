<?php
class Text extends Ivy\Model {

  public $id, $text, $token;
  protected $table = "text";

  // set
  public static function set($name,$value,$id = null) {
    global $page;
    include(_PUBLIC_PATH . $page->setTemplateFile(_PLUGIN_PATH . 'text/template/input.TypeText.php'));
  }

  public function purify($array) {
    $config = HTMLPurifier_Config::createDefault();
    $config->set('HTML.Nofollow', true);
    $config->set('HTML.TargetBlank', true);
    $config->set('HTML.AllowedAttributes', 'a.href');
    $config->set('HTML.AllowedAttributes', 'a.href');
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
