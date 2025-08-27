<?php

namespace Items\Collection\Audio;

use Items\ItemTrait;
use Ivy\Abstract\Model;
use Ivy\Core\Path;

class Audio extends Model
{
    use ItemTrait;

    protected string $table = 'audios';
    protected array $columns = [
        'file',
        'token'
    ];

    protected ?string $file;
    protected ?string $token;

    public function unlinkFile(): static
    {
        if($this->file){
            unlink(Path::get('MEDIA_PATH') . 'item/audio/' . $this->file);
        }
        $this->file = '';
        return $this;
    }

}
