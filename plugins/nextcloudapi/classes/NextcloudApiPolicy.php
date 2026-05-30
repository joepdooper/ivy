<?php

namespace NextcloudApi;


use Ivy\Shared\Base\Policy;

class NextcloudApiPolicy extends Policy
{
    public function add(): bool
    {
        return $this->canEditAsAdmin();
    }

    public function update(): bool
    {
        return $this->canEditAsAdmin();
    }

    public function delete(): bool
    {
        return $this->canEditAsAdmin();
    }

    public function servers(): bool
    {
        return $this->canEditAsEditor();
    }

    public function status(): bool
    {
        return $this->canEditAsEditor();
    }
}
