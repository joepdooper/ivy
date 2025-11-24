<?php

namespace Items;

use Ivy\Abstract\Model;
use Ivy\Trait\Factory;
use Ivy\Trait\HasFilters;
use Tags\TagTrait;

class Item extends Model
{
    use TagTrait, HasFilters, Factory;

    protected string $table = 'items';

    protected array $columns = [
        'user_id',
        'parent_id',
        'publish',
        'token',
        'sort',
        'slug'
    ];

    protected int $user_id;
    protected ?int $parent_id = null;
    protected int $publish = 0;

    protected ?string $token = null;
    protected ?string $date = null;
    protected ?int $sort = null;
    protected ?string $slug = null;

    protected bool $loadPlugins = false;
    protected bool $loadAuthors = false;

    public function plugin(): ?object
    {
        return $this->getRelation('plugin');
    }

    public function author(): ?Profile
    {
        return $this->getRelation('author');
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function populate(array $data): static
    {
        $data['publish'] = $data['publish'] ?? 0;
        $data['user_id'] = $data['user_id'] ?? $_SESSION['auth_user_id'];

        return parent::populate($data);
    }

    public function with(array $relations): static
    {
        if (in_array('plugins', $relations, true)) {
            $this->loadPlugins = true;
        }

        if (in_array('authors', $relations, true)) {
            $this->loadAuthors = true;
        }

        $native = array_diff($relations, ['plugins', 'authors']);
        if (!empty($native)) {
            parent::with($native);
        }

        return $this;
    }

    public function fetchAll(): array
    {
        $items = parent::fetchAll();

        if ($this->loadPlugins || $this->loadAuthors) {
            ItemLoader::attach($items, [
                'plugins' => $this->loadPlugins,
                'authors' => $this->loadAuthors
            ]);
        }

        return $items;
    }

    public function fetchOne(): ?static
    {
        $item = parent::fetchOne();

        if ($item && ($this->loadPlugins || $this->loadAuthors)) {
            $items = [$item];
            ItemLoader::attach($items, [
                'plugins' => $this->loadPlugins,
                'authors' => $this->loadAuthors
            ]);
            return $items[0];
        }

        return $item;
    }
}
