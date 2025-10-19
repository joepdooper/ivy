<?php

namespace Items;

use Symfony\Component\HttpFoundation\Request;

trait ItemTrait
{
    protected ?Item $item = null;

    public function getItem(): ?Item
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
        return $item instanceof Item ? $item : (new Item())->where('id', $item)->fetchOne();
    }

    public function delete(): string|int|bool
    {
        $this->item?->delete();
        return parent::delete();
    }

    public function insertItem(Request $request): static
    {
        $item = (new Item)->populate([
            'template_id' => (new ItemTemplate)->where('table', $this->table)->fetchOne()->getId(),
            'parent_id'   => ItemHelper::getParentId($request),
            'slug' => $this->slug ? ItemHelper::createSlug(!empty($request->get($this->slug)) ? $request->get($this->slug) : $this->{$this->slug}) : null,
            'table_id'    => $this->getId(),
        ])->insert();

        $this->item = $this->resolveItem((int)$item);

        return $this;
    }

    public function createItemFromRequest(Request $request): void
    {
        $this->createFromRequest($request->request->all());
        $this->insertItem($request);
    }

    public function updateItemFromRequest(Request $request): void
    {
        $this->updateFromRequest($request->request->all());
        $this->item->populate([
            'published' => $request->get('publish')
        ])->update();
    }
}