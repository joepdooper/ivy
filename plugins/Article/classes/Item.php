<?php
namespace Article;

use Ivy\Model;

class Item extends Model {

  public int $id;
  public string $title;
  public int $subject;
  public string $image;
  public int $token;

  protected $table = "article";

}
