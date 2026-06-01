<?php

namespace NextcloudApi;


use Ivy\Shared\Base\Policy;

class NextcloudApiPolicy extends Policy
{
    public function add(NextcloudApi $nextcloudApi): bool
    {
        return $this->canEditAsAdmin();
    }

    public function update(NextcloudApi $nextcloudApi): bool
    {
        return $this->canEditAsAdmin();
    }

    public function delete(NextcloudApi $nextcloudApi): bool
    {
        return $this->canEditAsAdmin();
    }

    public function index(NextcloudApi $nextcloudApi): bool
    {
        return $this->canEditAsEditor();
    }

    public function status(NextcloudApi $nextcloudApi): bool
    {
        return $this->canEditAsEditor();
    }
}
