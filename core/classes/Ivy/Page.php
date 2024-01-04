<?php
namespace Ivy;

class Page {

  public $filter = null;
  public $css = array();
  public $js = array();
  public $route, $id, $url, $content;

  function setDate($name,$value,$id = null) {
    include(_PUBLIC_PATH . 'core/inputs/input.TypeDate.php');
  }

  function setTime($name,$value,$id = null) {
    include(_PUBLIC_PATH . 'core/inputs/input.TypeTime.php');
  }

  function setDateTime($name,$value,$id = null) {
    include(_PUBLIC_PATH . 'core/inputs/input.TypeDateTime.php');
  }

  function setTemplateFile($file) {
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

  function addCSS($file) {
    array_push($this->css, $file);
  }

  function addJS($file) {
    array_push($this->js, $file);
  }

}
?>
