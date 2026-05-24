<?php

namespace NextcloudApi;


use Ivy\Shared\Base\Policy;

class NextcloudApiPolicy extends Policy
{
    public function servers(): bool
    {
        return $this->canEditAsEditor();
    }

    public function status(): bool
    {
        return $this->canEditAsEditor();
    }

    public function sync(): bool
    {
        return $this->canEditAsEditor();
    }
}
