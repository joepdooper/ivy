<?php

namespace Items;

use Ivy\Abstract\Model;
use Ivy\Manager\DatabaseManager;

class Item extends Model
{
    protected string $table = 'items';
    protected array $columns = [
        'user_id',
        'table_id',
        'parent_id',
        'template_id',
        'position_id',
        'published',
        'token',
        'date',
        'sort',
        'slug'
    ];

    protected int $user_id;
    protected int $table_id;
    protected ?int $parent_id;
    protected int $template_id;
    protected int $published;

    protected ?string $token;
    protected string $date;
    protected ?int $sort;
    protected ?string $slug;

    protected bool $author;
    protected string $namespace;
    protected string $name;
    protected ?string $plugin_url;

    protected string $route;
    protected string $url;


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
        `plugin`.`active` FROM `items`
        INNER JOIN `item_template` ON `item_template`.`id` = `items`.`template_id`
        INNER JOIN `plugin` ON `plugin`.`url` = `item_template`.`plugin_url`
        WHERE `plugin`.`active` != '0'";
    }

    // -- insert
    public function populate(array $data): static
    {
        $data['published'] = $data['published'] ?? 0;
        $data['user_id'] = $data['user_id'] ?? $_SESSION['auth_user_id'];
        $data['table_id'] = $data['table_id'] ?? ($this->table_id ?? DatabaseManager::connection()->getLastInsertId());

        return parent::populate($data);
    }

    public function getAuthor(): bool
    {
        return $this->author;
    }

    public function setAuthor($value): void
    {
        $this->author = $value;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    public function setNamespace($value): void
    {
        $this->namespace = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName($value): void
    {
        $this->name = $value;
    }

    public function getPluginUrl(): string
    {
        return $this->plugin_url;
    }

    public function setPluginUrl($value): void
    {
        $this->plugin_url = $value;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function setRoute($value): void
    {
        $this->route = $value;
    }

    public function render(): void
    {
        $itemTemplateClass = "{$this->namespace}\\{$this->name}Template";
        if (class_exists($itemTemplateClass)) {
            (new $itemTemplateClass)->render($this);
        }
    }

}
