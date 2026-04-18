<?php

namespace Contacts;

use Ivy\Abstract\Form;

class ContactForm extends Form
{
    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'not_nullable', 'string'],
            'email' => ['nullable', 'email'],
            'birthday' => ['nullable'],
            'profile_id' => ['nullable', 'numeric'],
        ];
    }
}
