<?php

namespace Items\Collection\Vimeo;

use Ivy\Abstract\Model;

class Vimeo extends Model
{
    protected string $table = "vimeos";
    protected array $columns = [
        'vimeo_video_id',
        'token'
    ];
    public string $vimeo_video_id;
    public ?string $token;
}
