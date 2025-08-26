<?php

namespace Items\Collection\Youtube;

use Ivy\Abstract\Model;

class Youtube extends Model
{
    protected string $table = "youtubes";
    protected array $columns = [
        'youtube_video_id',
        'token'
    ];
    public string $youtube_video_id;
    public ?string $token;
}
