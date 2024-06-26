<?php
namespace Image;

use Ivy\File;
use Ivy\Model;
use Ivy\Template;

class Item extends Model {

  public $id, $file, $token;
  protected $table = 'image';

  public static function set($name,$value,$id = null) {
    include(_PUBLIC_PATH . Template::file(_PLUGIN_PATH . 'Image/template/input.TypeImage.php'));
  }

  public function upload($image) {
    $file = new File();
    $file->name = bin2hex(random_bytes(16));
    $file->allowed = array('image/*');
    $image_sizes = new \Image\Settings();
    foreach ($image_sizes->get()->data() as $size){
      $file->width = $size->value;
      $file->directory = _PUBLIC_PATH . '/media/item/' . $size->name;
      $file->image_convert = null;
      $this->file = $file->upload($image);
      $file->image_convert = 'webp';
      $this->file = $file->upload($image);
    }
    return $this->file;
  }

  public function delete_set($file = null) {
    $image = isset($file) ? $file : $this->data->file;
    $image_sizes = new \Image\Settings();
    foreach ($image_sizes->get()->data() as $size){
      unlink(_PUBLIC_PATH . 'media/item/' . $size->name . '/' . $image);
      unlink(_PUBLIC_PATH . 'media/item/' . $size->name . '/' . pathinfo($image)['filename'] . '.webp');
    }
  }

}
?>
