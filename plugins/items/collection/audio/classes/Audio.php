<?php

namespace Items\Collection\Audio;

use Items\ItemTrait;
use Ivy\Abstract\Model;

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

    public function delete():string|int|bool {
        (new AudioFile)->remove($this->file);
        $this->item->delete();
        return parent::delete();
    }
}
