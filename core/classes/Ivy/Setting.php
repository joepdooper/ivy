<?php
namespace Ivy;

#[\AllowDynamicProperties]

class Setting extends Model {

  protected $table = 'setting';
  protected $path = _BASE_PATH . 'admin/setting';

}
?>
