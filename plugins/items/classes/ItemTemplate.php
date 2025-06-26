<?php

namespace Items;

use Ivy\Abstract\Model;

class ItemTemplate extends Model
{
    protected string $table = 'item_templates';
    protected array $columns = [
        'name',
        'plugin_url',
        'route',
        'namespace'
    ];

    protected string $name;
    protected string $plugin_url;
    protected string $route;
    protected string $namespace;
    protected string $active;

    public function setActive(int $bool): void
    {
        $this->active = $bool;
    }

    public function getActive(): int
    {
        return $this->active;
    }
}