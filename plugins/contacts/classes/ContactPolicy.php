<?php

namespace Contacts;


use Ivy\Shared\Base\Policy;

class ContactPolicy extends Policy
{
    public function index(Contact $contact): bool
    {
        return $this->canEditAsEditor();
    }

    public function sync(Contact $contact): bool
    {
        return $this->canEditAsEditor();
    }

    public function save(Contact $contact): bool
    {
        return $this->canEditAsEditor();
    }

    public function add(Contact $contact): bool
    {
        return $this->canEditAsEditor();
    }

    public function update(Contact $contact): bool
    {
        return $this->canEditAsEditor();
    }

    public function delete(Contact $contact): bool
    {
        if (! $contact->profile_id && $this->canEditAsEditor()) {
            return true;
        }

        return false;
    }
}
