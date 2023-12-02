<?php
namespace Ivy;

#[\AllowDynamicProperties]

class Item extends Model {

  protected $table = 'items';

  public function __construct()
  {
    $this->query = "SELECT
    `items`.*,
    `item_template`.`plugin`,
    `item_template`.`table`,
    `item_template`.`name`,
    `item_template`.`item_template_file`,
    `item_template`.`page_template_file`,
    `plugin`.`folder`,
    `plugin`.`active`
    FROM `items`, `item_template`, `plugin`
    WHERE `item_template`.`id` = `items`.`template`
    AND `plugin`.`folder` = `item_template`.`plugin`
    AND `plugin`.`active` != '0'
    ";
  }

  // -- get
  public function get()
  {
    parent::get();

    foreach ($this->data as $key => $value) {
      $this->data[$key]->author = isset($_SESSION['auth_user_id']) ? (($this->data[$key]->user_id == $_SESSION['auth_user_id']) ? true : false) : false;
    }

    return $this;
  }

  // -- get row
  public function getRow()
  {
    parent::getRow();

    $this->data->author = isset($_SESSION['auth_user_id']) ? (($this->data->user_id == $_SESSION['auth_user_id']) ? true : false) : false;

    return $this;
  }

  // -- insert
  public function insert($set)
  {
    global $db;

    $set['published'] = $set['published'] ?? 0;
    $set['user_id'] = $set['user_id'] ?? $_SESSION['auth_user_id'];
    $set['table_id'] = $set['table_id'] ?? $db->getLastInsertId();

    return parent::insert($set);
  }

}
?>
