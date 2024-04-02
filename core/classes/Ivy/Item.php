<?php
namespace Ivy;

#[\AllowDynamicProperties]

class Item extends Model {

    protected $table = 'items';

    public function __construct()
    {
        $this->query = "SELECT
    `items`.*,
    `item_template`.`name`,
    `item_template`.`plugin_url`,
    `item_template`.`route`,
    `item_template`.`table`,
    `item_template`.`file`,
    `plugin`.`url`,
    `plugin`.`active`,
    `position`.`value` AS `position`
    FROM `items`
    INNER JOIN `item_template` ON `item_template`.`id` = `items`.`template`
    INNER JOIN `plugin` ON `plugin`.`url` = `item_template`.`plugin_url`
    LEFT JOIN `position` ON `position`.`id` = `items`.`position_id`
    WHERE `plugin`.`active` != '0'";
    }

    // -- get
    public function get()
    {
        parent::get();

        foreach ($this->data as $key => $value) {
            $this->data[$key]->author = isset($_SESSION['auth_user_id']) && $this->data[$key]->user_id == $_SESSION['auth_user_id'];
        }

        return $this;
    }

    // -- get row
    public function getRow()
    {
        parent::getRow();

        $this->data->author = isset($_SESSION['auth_user_id']) && isset($this->data->user_id) && ($this->data->user_id == $_SESSION['auth_user_id']);

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

    public function delete()
    {
        global $db;

        parent::delete();

        $children = (new \Ivy\Item())->where('parent', $this->data->id)->get()->data();
        if (!empty($children)) {
            foreach ($children as $child) {
                $db->delete(
                    $child->table,
                    [
                        'id' => $child->table_id
                    ]
                );
                $db->delete(
                    'items',
                    [
                        'id' => $child->id
                    ]
                );
            }
        }
    }

    public static function position($position, $items) {

        if($items) {
            return array_filter($items, function($item) use ($position) {
                return property_exists($item, 'position') && $item->position === $position;
            });
        }

    }

}
