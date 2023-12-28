<?php
namespace youtube;

use Ivy\Model;

class Item extends Model {

  public $id, $youtube_video_id, $token;
  protected $table = "youtube";

}
?>
