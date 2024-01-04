<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

#[\AllowDynamicProperties]

class Template extends Model {

  protected $table = 'template';
  protected $path = _BASE_PATH . 'admin/template';

  public static function define_browser() {
    $IE11orOlderBrowser = preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~Trident/7.0(.*)?; rv:11.0~', $_SERVER['HTTP_USER_AGENT']);
    if ($IE11orOlderBrowser) {
      Message::add('Please use a more modern browser');
    }
  }

}
?>
