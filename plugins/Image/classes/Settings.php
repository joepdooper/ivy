<?php
namespace Image;

use Ivy\Model;

class Settings extends Model {

  protected $table = 'image_sizes';
  protected $path = _BASE_PATH . 'plugin/Image';

  public function save($array)
  {
    if (isset($array['value'])) {
      $array['value'] = !empty($array['value']) ? (int)$array['value'] : null;
    }
    return parent::save($array);
  }

}
?>
