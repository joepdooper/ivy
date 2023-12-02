<?php
namespace Ivy;

use HTMLPurifier_Config;
use HTMLPurifier;

#[\AllowDynamicProperties]

class Template extends Model {

  protected $table = 'template';
  protected $path = _BASE_PATH . 'admin/template';

}
?>
