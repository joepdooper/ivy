<?php
namespace audio;

use Ivy\Model;
use Ivy\File;
use Verot\Upload\Upload;

class Item extends Model {

  public $id, $file, $token;
  protected $table = 'audio';
  const _AUDIO_PATH = 'audio/';

  public function upload($audio) {
    $file = new File();
    $file->name = bin2hex(random_bytes(16));
    $file->allowed = array('audio/*');
    $file->directory = _PUBLIC_PATH . _MEDIA_PATH . 'item/' . self::_AUDIO_PATH;
    return $file->upload($audio);
  }

  public function unlink($file = null) {
    $audio = isset($file) ? $file : $this->file;
    unlink(_PUBLIC_PATH . _MEDIA_PATH . 'item/' . self::_AUDIO_PATH . $audio);
  }

  public static function set($name,$value,$id = null) {
    global $page;
    include(_PUBLIC_PATH . $page->setTemplateFile(_PLUGIN_PATH . 'audio/template/input.TypeAudio.php'));
  }

}
?>
