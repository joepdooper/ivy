<?php

namespace NextcloudApi;

use Ivy\Shared\Base\Form;
use Ivy\Shared\Presentation\Rule\UniqueRule;

class NextcloudApiForm extends Form
{
    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'protocol' => ['required', 'not_nullable', 'string'],
            'url' => ['required', 'string', new UniqueRule([NextcloudApi::class])],
            'port' => ['numeric', 'nullable'],
            'username' => ['string', 'nullable'],
            'password' => ['string', 'nullable'],
        ];
    }
}
