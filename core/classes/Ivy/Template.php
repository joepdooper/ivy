<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

#[\AllowDynamicProperties]

class Template extends Model {

  protected $table = 'template';
  protected $path = _BASE_PATH . 'admin/template';

  public $filter = null;
  public $css = array();
  public $js = array();
  public $route, $id, $url, $content;

  public function setTemplateFile($file) {
    if (file_exists(_TEMPLATE_SUB . $file)) {
      return _TEMPLATE_SUB . $file;
    } elseif(file_exists(_TEMPLATE_BASE . $file)) {
      return _TEMPLATE_BASE . $file;
    } elseif(file_exists($file)) {
      return $file;
    } else {
      return false;
    }
  }

  public function addCSS($file) {
    array_push($this->css, $file);
  }

  public function addJS($file) {
    array_push($this->js, $file);
  }

  public static function define_browser() {
    $IE11orOlderBrowser = preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~Trident/7.0(.*)?; rv:11.0~', $_SERVER['HTTP_USER_AGENT']);
    if ($IE11orOlderBrowser) {
      Message::add('Please use a more modern browser');
    }
  }

}
?>
