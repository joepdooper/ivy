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
        'item_id',
        'token'
    ];

    protected ?string $file;
    protected int $item_id;
    protected ?string $token;

    public function delete():bool {
        $file = new ImageFile();
        foreach ((new ImageSize)->fetchAll() as $imageSize) {
            $file->setUploadPath('item'. DIRECTORY_SEPARATOR . $imageSize->name)->remove($this->file);
        }
        $this->item->delete();
        return parent::delete();
    }
}
