<?php

namespace Items;

use Delight\Db\Throwable\EmptyWhereClauseError;
use Ivy\Model;

class Item extends Model
{

    protected string $table = 'items';

    public bool $published;
    public string $template;
    public int $id;
    public int $user_id;
    public int $table_id;
    public ?int $parent;
    public ?string $token;
    public string $date;
    public ?int $sort;
    public ?string $style;
    public ?string $slug;
    public string $name;
    public string $plugin_url;
    public string $route;
    public string $url;
    public bool $active;
    public bool $author;
    public string $namespace;
    public Controller $controller;

    public function __construct()
    {
        parent::__construct();
        $this->query = "SELECT
    `items`.*,
    `item_template`.`name`,
    `item_template`.`plugin_url`,
    `item_template`.`route`,
    `item_template`.`table`,
    `item_template`.`namespace`,
    `plugin`.`url`,
    `plugin`.`active`
    FROM `items`
    INNER JOIN `item_template` ON `item_template`.`id` = `items`.`template`
    INNER JOIN `plugin` ON `plugin`.`url` = `item_template`.`plugin_url`
    WHERE `plugin`.`active` != '0'";
    }

    // -- get
    public function get(): static
    {
        parent::get();

        foreach ($this->rows as $key => $value) {
            $this->rows[$key]->author = isset($_SESSION['auth_user_id']) && $this->rows[$key]->user_id == $_SESSION['auth_user_id'];
        }

        return $this;
    }

    // -- get row
    public function getRow(): static
    {
        parent::getRow();
        $this->data->author = isset($_SESSION['auth_user_id']) && isset($this->single()->user_id) && ($this->single()->user_id == $_SESSION['auth_user_id']);

        return $this;
    }

    // -- insert
    public function insert($set): bool|int|string
    {
        $set['published'] = $set['published'] ?? 0;
        $set['user_id'] = $set['user_id'] ?? $_SESSION['auth_user_id'];
        $set['table_id'] = $set['table_id'] ?? DB::$connection->getLastInsertId();

        return parent::insert($set);
    }

    public function delete(): int
    {
        $lastInsertId = parent::delete();

        $children = (new Item())->where('parent', $this->single()->id)->get()->all();
        if (!empty($children)) {
            foreach ($children as $child) {
                try {
                    DB::$connection->delete(
                        $child->table,
                        [
                            'id' => $child->table_id
                        ]
                    );
                } catch (EmptyWhereClauseError $e) {
                    Message::add($e->getMessage());
                }
                try {
                    DB::$connection->delete(
                        'items',
                        [
                            'id' => $child->id
                        ]
                    );
                } catch (EmptyWhereClauseError $e) {
                    Message::add($e->getMessage());
                }
            }
        }

        return $lastInsertId;
    }

}
