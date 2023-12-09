<?php
use Verot\Upload\Upload;
use Ivy\File;

class Image extends Ivy\Model {

  public $id, $file, $token;
  protected $table = 'image';

  public static function set($name,$value,$id = null) {
    global $page;
    include(_PUBLIC_PATH . $page->setTemplateFile(_PLUGIN_PATH . 'image/template/input.TypeImage.php'));
  }

  public function upload($image) {
    $file = new File();
    $file->name = bin2hex(random_bytes(16));
    $file->allowed = array('image/*');
    $image_sizes = new ImageSizes();
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

  public function unlink($file = null) {
    $image = isset($file) ? $file : $this->data->file;
    $image_sizes = new ImageSizes();
    foreach ($image_sizes->get()->data() as $size){
      unlink(_PUBLIC_PATH . 'media/item/' . $size->name . '/' . $image);
      unlink(_PUBLIC_PATH . 'media/item/' . $size->name . '/' . pathinfo($image)['filename'] . '.webp');
    }
  }

}
?>
