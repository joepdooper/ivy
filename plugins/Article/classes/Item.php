<?php
namespace Article;

use Ivy\Model;

class Item extends Model {

  public $id, $title, $subtitle, $subject, $image, $token;
  protected $table = "article";

}
?>
