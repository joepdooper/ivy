<?php
namespace Documentation;

use Ivy\Model;

class Item extends Model {

  public $id, $title, $subtitle, $subject, $token;
  protected $table = "documentation";

}
?>
