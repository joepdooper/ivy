<?php

namespace Items\Collection\Article;

use Items\Collection\Image\ImageFile;
use Items\Collection\Image\ImageSize;
use Items\ItemTrait;
use Ivy\Abstract\Model;
use Tags\TagTrait;

class Article extends Model
{
    use ItemTrait, TagTrait;

    protected string $table = "articles";
    protected string $type = "article";
    protected array $columns = [
        'title',
        'subtitle',
        'image',
        'token'
    ];

    protected string $title;
    protected ?string $subtitle;
    protected ?string $image;
    protected ?string $token;

    public function delete():bool {
        $file = new ImageFile();
        foreach ((new ImageSize)->fetchAll() as $imageSize) {
            $file->setUploadPath('item'. DIRECTORY_SEPARATOR . $imageSize->name)->remove($this->image);
        }
        $this->item->delete();
        return parent::delete();
    }
}
