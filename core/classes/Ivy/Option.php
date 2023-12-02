<?php
namespace Ivy;

#[\AllowDynamicProperties]

class Option extends Model {

  protected $table = 'option';
  protected $path = _BASE_PATH . 'admin/option';

}
?>
