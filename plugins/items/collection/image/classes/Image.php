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
        $file = new ImageFile();
        foreach ((new ImageSize)->fetchAll() as $imageSize) {
            $file->setUploadPath('item'. DIRECTORY_SEPARATOR . $imageSize->name)->remove($this->file);
        }
        $this->item->delete();
        return parent::delete();
    }
}
