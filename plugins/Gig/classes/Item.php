<?php
namespace Gig;

use Ivy\Model;

class Item extends Model {

  public $id, $datetime, $venue, $address, $latitude, $longitude, $price, $url, $subject, $token;
  protected $table = "gig";

}
?>
