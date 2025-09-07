<?php

namespace Items\Collection\Audio;

use Ivy\Abstract\File;

class AudioFile extends File
{
    protected string $uploadPath = 'item' . DIRECTORY_SEPARATOR . 'audio';

    public function getAllowedMimeTypes(): array
    {
        return [
            'audio/*',
            'application/octet-stream'
        ];
    }

    public function getAllowedExtensions(): array
    {
        return ['mp3', 'wav', 'aiff', 'ogg'];
    }
}