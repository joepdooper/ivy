<?php
namespace docs;

use Ivy\Model;

class Item extends Model {

  public $id, $title, $subtitle, $subject, $token;
  protected $table = "docs";

}
?>
