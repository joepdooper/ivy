<?php

namespace Items\Collection\Image;

use Ivy\Abstract\Model;
use Ivy\Path;

class Image extends Model
{
    protected string $table = 'image';
    protected array $columns = [
        'file',
        'token'
    ];

    protected ?string $file;
    protected ?string $token;

    public function unlinkFile(): static
    {
        if($this->file){
            foreach ((new ImageSize)->fetchAll() as $size) {
                unlink(Path::get('PUBLIC_PATH') . 'media/item/' . $size->name . '/' . $this->file);
                unlink(Path::get('PUBLIC_PATH') . 'media/item/' . $size->name . '/' . pathinfo($this->file)['filename'] . '.webp');
            }
        }
        $this->file = '';
        return $this;
    }

}
