<?php

namespace Moments;

use Ivy\Abstract\Form;

class MomentForm extends Form
{
    /**
     * @return array<string, mixed>
     */
    protected function rules(): array
    {
        return [
            'title' => 'between_len,5;100',
            'start_date' => 'required|date',
            'end_date' => 'date',
            'start_time' => 'valid_time',
            'end_time' => 'valid_time',
            'city' => 'between_len,2;100',
            'country' => 'between_len,2;100',
        ];
    }
}
