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

    protected string $itemMediaPath = 'item/article';

    public function getItemMediaPath(): string
    {
        return $this->itemMediaPath;
    }

    public function delete():string|int|bool {
        $this->unlinkImage();
        $this->item->delete();
        return parent::delete();
    }

    public function unlinkImage(): string
    {
        if($this->image){
            foreach ((new ImageSize)->fetchAll() as $size) {
                unlink(Path::get('MEDIA_PATH') . 'item/' . $size->name . DIRECTORY_SEPARATOR . $this->image);
                unlink(Path::get('MEDIA_PATH') . 'item/' . $size->name . '/' . pathinfo($this->image)['filename'] . '.webp');
            }
        }
        return '';
    }
}
