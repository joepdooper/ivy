<?php

namespace Tag;

use Ivy\Model;

class Tag extends Model
{
    protected string $table = 'tag';
    protected string $path = 'plugin/tag';
    protected array $columns = [
        'value'
    ];

    protected string $value;

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue(string $value): void
    {
        $this->value = $value;
    }

}
