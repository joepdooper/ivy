<?php

namespace Items\Collection\Image;

use Ivy\Abstract\Model;

class ImageSize extends Model
{
    protected string $table = 'image_sizes';
    protected string $path = 'plugin/image';
    protected array $columns = [
        'name',
        'bool',
        'value',
        'info'
    ];

    protected string $name;
    protected int $bool;
    protected ?int $value;
    protected ?string $info;

    public function save($data): bool|int
    {
        if (isset($data['value'])) {
            $data['value'] = !empty($data['value']) ? (int)$data['value'] : null;
        }
        return parent::save($data);
    }
}
