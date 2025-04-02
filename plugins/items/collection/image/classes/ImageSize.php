<?php

namespace Items\Collections\Image;

use Ivy\Model;

class ImageSize extends Model
{

    protected string $table = 'image_sizes';
    protected string $path = Path::get('BASE_PATH') . 'plugin/image';
    protected array $columns = [
        'name',
        'bool',
        'value',
        'info'
    ];

    private string $name;
    private int $bool;
    private int $value;
    private string $info;

    public function save($data): bool|int
    {
        if (isset($data['value'])) {
            $data['value'] = !empty($data['value']) ? (int)$data['value'] : null;
        }
        return parent::save($data);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBool(): int
    {
        return $this->bool;
    }

    public function setBool(int $bool): void
    {
        $this->bool = $bool;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getInfo(): string
    {
        return $this->info;
    }

    public function setInfo(string $info): void
    {
        $this->info = $info;
    }

}
