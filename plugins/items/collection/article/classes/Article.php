<?php

namespace Items\Collection\Article;

use Items\Collection\Image\ImageService;
use Items\ItemTrait;
use Ivy\Abstract\Model;
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
        ImageService::unlink($this->image);
        return parent::delete();
    }
}
