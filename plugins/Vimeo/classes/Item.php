<?php
namespace Vimeo;

use Ivy\Model;

class Item extends Model {

  public $id, $vimeo_video_id, $token;
  protected $table = "vimeo";

}
?>
