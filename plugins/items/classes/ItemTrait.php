<?php

namespace Items;

trait ItemTrait
{
    protected ?Item $item = null;

    public function getItem(): Item
    {
        return $this->item;
    }

    public function fetchOneWithItem(int|Item $item): static
    {
        $item = $this->resolveItem($item);
        return $this->fetchFromItem($item);
    }

    public function fetchOneWithSlug(string $slug): static
    {
        $item = (new Item())->where('slug', $slug)->fetchOne();
        return $this->fetchFromItem($item);
    }

    protected function fetchFromItem(Item $item): static
    {
        $this->item = $item;

        $result = $this->where('id', $item->table_id)->fetchOne();
        $result->item = $item;

        return $result;
    }

    protected function resolveItem(int|Item $item): Item
    {
        return $item instanceof Item
            ? $item
            : (new Item())->where('id', $item)->fetchOne();
    }
}
