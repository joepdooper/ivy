<?php

namespace Tags;

use Ivy\Shared\Base\Form;
use Ivy\Shared\Presentation\Rule\UniqueRule;

class TagForm extends Form
{
    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'name' => ['required', 'not_nullable', new UniqueRule([Tag::class])],
        ];
    }
}
