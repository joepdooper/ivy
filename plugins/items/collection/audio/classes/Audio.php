<?php

namespace Items\Collection\Audio;

use Ivy\Abstract\Model;
use Ivy\Path;

class Audio extends Model
{
    protected string $table = 'audio';
    protected array $columns = [
        'file',
        'token'
    ];

    protected ?string $file;
    protected ?string $token;

    public function unlinkFile(): static
    {
        if($this->file){
            unlink(Path::get('PUBLIC_PATH') . Path::get('MEDIA_PATH') . 'item/audio/' . $this->file);
        }
        $this->file = '';
        return $this;
    }

}
