<?php
namespace Ivy;

class Message {

  public $tpl;

  function __construct() {
    if(!isset($_SESSION["flash_messages"])){
      $_SESSION["flash_messages"] = array();
    }
    $this->tpl = '';
  }

  public static function add($value, $redirect = null) {
    if (isset($_SESSION["flash_messages"]) && !in_array($value, $_SESSION["flash_messages"])){
      $_SESSION["flash_messages"][] = $value;
    }
    if ($redirect){
      if (headers_sent()) {
        print'<script> location.replace("' . $redirect .'"); </script>';
      } else {
        header('location:' . $redirect,  true,  302);
        exit;
      }
    }
  }

  public function display($value = null) {
    if($value && !empty($this->tpl)){
      include $this->tpl;
    }
    elseif(!empty($_SESSION["flash_messages"]) && !empty($this->tpl)){
      foreach($_SESSION["flash_messages"] as $key => $value){
        include $this->tpl;
      }
    }
    $this->remove();
  }

  private function remove() {
    $_SESSION["flash_messages"] = array();
  }

}
?>
