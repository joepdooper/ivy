<?php

namespace Items;

use Illuminate\Database\Eloquent\Model;
use Ivy\Model\Plugin;
use Ivy\Model\Profile;
use Ivy\Trait\Factory;
use Ivy\Trait\HasFilters;
use Tags\TagTrait;

class Item extends Model
{
    use Factory, HasFilters, TagTrait;

    protected $fillable = [
        'user_id',
        'parent_id',
        'publish',
        'token',
        'sort',
        'slug',
    ];

    protected array $filterable = [
        'slug',
    ];

    protected bool $loadPlugins = false;

    protected bool $loadAuthors = false;

    public function plugin(): ?Plugin
    {
        return $this->getRelation('plugin');
    }

    public function profile(): ?Profile
    {
        return $this->getRelation('author');
    }

    public function populate(array $data): static
    {
        $data['publish'] = $data['publish'] ?? 0;
        $data['user_id'] = $data['user_id'] ?? $_SESSION['auth_user_id'];

        return parent::populate($data);
    }

//    public function with(array $relations)
//    {
//        if (in_array('plugins', $relations, true)) {
//            $this->loadPlugins = true;
//        }
//
//        if (in_array('authors', $relations, true)) {
//            $this->loadAuthors = true;
//        }
//
//        $native = array_diff($relations, ['plugins', 'authors']);
//        if (! empty($native)) {
//            parent::with($native);
//        }
//
//        return $this;
//    }

//    public function fetchAll(): array
//    {
//        $items = parent::fetchAll();
//
//        if ($this->loadPlugins || $this->loadAuthors) {
//            ItemLoader::attach($items, [
//                'plugins' => $this->loadPlugins,
//                'authors' => $this->loadAuthors,
//            ]);
//        }
//
//        return $items;
//    }

//    public function fetchOne(): ?static
//    {
//        $item = parent::fetchOne();
//
//        if ($item && ($this->loadPlugins || $this->loadAuthors)) {
//            $items = [$item];
//            ItemLoader::attach($items, [
//                'plugins' => $this->loadPlugins,
//                'authors' => $this->loadAuthors,
//            ]);
//
//            return $items[0];
//        }
//
//        return $item;
//    }
}
