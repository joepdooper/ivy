<?php

namespace Items\Collection\Image;

use Items\ItemTrait;
use Ivy\Abstract\Model;

class Image extends Model
{
    use ItemTrait;

    protected string $table = 'images';
    protected array $columns = [
        'file',
        'token'
    ];

    protected ?string $file;
    protected ?string $token;

    public function delete():string|int|bool {
        $this->item->delete();
        return parent::delete();
    }
}
