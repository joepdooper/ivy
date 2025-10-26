<?php

namespace Items;

use Ivy\Abstract\Model;
use Ivy\Manager\DatabaseManager;
use Ivy\Trait\Factory;
use Ivy\Trait\Filter;
use Tags\TagTrait;

class Item extends Model
{
    use TagTrait, Filter, Factory;

    protected string $table = 'items';
    protected array $columns = [
        'user_id',
        'table_id',
        'parent_id',
        'template_id',
        'position_id',
        'publish',
        'token',
        'date',
        'sort',
        'slug'
    ];

    protected int $user_id;
    protected int $table_id;
    protected ?int $parent_id;
    protected int $template_id;
    protected int $publish;

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
        `item_templates`.`name`,
        `item_templates`.`plugin_url`,
        `item_templates`.`route`,
        `item_templates`.`table`,
        `item_templates`.`namespace`,
        `plugins`.`url`,
        `plugins`.`active` FROM `items`
        INNER JOIN `item_templates` ON `item_templates`.`id` = `items`.`template_id`
        INNER JOIN `plugins` ON `plugins`.`url` = `item_templates`.`plugin_url`
        WHERE `plugins`.`active` != '0'";
    }

    // -- insert
    public function populate(array $data): static
    {
        $data['publish'] = $data['publish'] ?? 0;
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
