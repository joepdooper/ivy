<?php
namespace Audio;

use Ivy\Model;
use Ivy\File;
use Verot\Upload\Upload;

class Item extends Model {

  public $id, $file, $token;
  protected $table = 'audio';
  const _AUDIO_PATH = 'audio' . DIRECTORY_SEPARATOR;

  public function upload($audio) {
    $file = new File();
    $file->name = bin2hex(random_bytes(16));
    $file->allowed = array('audio/*');
    $file->directory = _PUBLIC_PATH . _MEDIA_PATH . 'item/' . self::_AUDIO_PATH;
    return $file->upload($audio);
  }

  public function delete_file($file = null) {
    $audio = isset($file) ? $file : $this->data->file;
    unlink(_PUBLIC_PATH . _MEDIA_PATH . 'item/' . self::_AUDIO_PATH . $audio);
  }

  public static function set($name,$value,$id = null) {
    include(_PUBLIC_PATH . \Ivy\Template::setTemplateFile(_PLUGIN_PATH . 'Audio/template/input.TypeAudio.php'));
  }

}
?>
