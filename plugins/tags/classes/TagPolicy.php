<?php

namespace Tags;


use Ivy\Shared\Base\Policy;

class TagPolicy extends Policy
{
    public function index(Tag $tag): bool
    {
        return $this->canEditAsEditor();
    }
    public function sync(Tag $tag): bool
    {
        return $this->canEditAsEditor();
    }

    public function add(Tag $tag): bool
    {
        return $this->canEditAsEditor();
    }

    public function update(Tag $tag): bool
    {
        return $this->canEditAsEditor();
    }

    public function delete(Tag $tag): bool
    {
        return $this->canEditAsEditor();
    }
}
