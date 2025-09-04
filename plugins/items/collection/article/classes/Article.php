<?php

namespace Items\Collection\Article;

use Items\Collection\Image\ImageService;
use Items\Collection\Image\ImageSize;
use Items\ItemTrait;
use Ivy\Abstract\Model;
use Ivy\Core\Path;
use Tags\TagTrait;

class Article extends Model
{
    use ItemTrait, TagTrait;

    protected string $table = "articles";
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

    public function delete():string|int|bool {
        $this->item->delete();
        return parent::delete();
    }
}
