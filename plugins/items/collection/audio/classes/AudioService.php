<?php

namespace Items\Collection\Audio;

use Ivy\File;
use Ivy\Path;

class AudioService
{
    public static function upload($audio): ?string
    {
        $fileName = null;

        try {
            $file = new File;
            $file->setName(bin2hex(random_bytes(16)));
            $file->setAllowed(array('audio/*'));
            $file->setDirectory(Path::get('PUBLIC_PATH') . Path::get('MEDIA_PATH') . 'item/audio');
            $fileName = $file->upload($audio);
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

        return $fileName;
    }

    public static function unlink($audio): string
    {
        if($audio){
            unlink(Path::get('PUBLIC_PATH') . Path::get('MEDIA_PATH') . 'item/audio/' . $audio);
        }
        return '';
    }
}
