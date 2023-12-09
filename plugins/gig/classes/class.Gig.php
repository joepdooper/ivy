<?php
class Gig extends Ivy\Model {

  public $id, $datetime, $venue, $address, $latitude, $longitude, $price, $url, $subject, $token;
  protected $table = "gig";

}
?>
