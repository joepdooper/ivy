<?php

namespace Items;

use Symfony\Component\HttpFoundation\Request;

trait ItemTrait
{
    public function item(): ?Item
    {
        return $this->hasOne(Item::class, 'id');
    }

    public function getSlug() {
        return $this->slug;
    }

    public function delete(): bool
    {
        $this->item->delete();
        return parent::delete();
    }

    public function insertItem(Request $request): static
    {
        $slugValue = $this->slug
            ? ItemHelper::createSlug($request->get($this->slug) ?? $this->{$this->slug})
            : null;

        $item = (new Item())->populate([
            'parent_id' => ItemHelper::getParentId($request),
            'slug'      => $slugValue,
        ])->insert();

        $this->item = $item;

        return $this;
    }

    public function createItemFromRequest(Request $request): void
    {
        $this->insertItem($request);
        $request->request->set('item_id', $this->item->id);
        $this->createFromRequest($request->request->all());
    }

    public function updateItemFromRequest(Request $request): void
    {
        $this->updateFromRequest($request->request->all());

        if (!$this->item) return;

        $newSlug = $this->slug
            ? ItemHelper::slugify($request->get($this->slug) ?? $this->{$this->slug})
            : null;

        $data = [
            'publish' => $request->get('publish', $this->item->publish)
        ];

        if ($newSlug !== $this->item->slug) {
            $data['slug'] = $newSlug;
        }

        $this->item->populate($data)->update();
    }
}
