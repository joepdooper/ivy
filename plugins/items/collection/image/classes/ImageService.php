<?php

namespace Items\Collection\Image;

use Ivy\File;
use Ivy\Path;

class ImageService
{
    public static function upload($image): ?string
    {
        $fileName = null;
        try {
            $file = new File;
            $file->setName(bin2hex(random_bytes(16)));
            $file->setAllowed(array('image/*'));
            foreach ((new ImageSize)->fetchAll() as $size) {
                if($size->value){
                    $file->setWidth($size->value);
                }
                $file->setDirectory(Path::get('PUBLIC_PATH') . Path::get('MEDIA_PATH') . 'item/' . $size->name);
                $fileName = $file->upload($image);
                $file->setImageConvert( 'webp');
                $file->upload($image);
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }

        return $fileName;
    }

    public static function unlink($image): string
    {
        if($image){
            foreach ((new ImageSize)->fetchAll() as $size) {
                unlink(Path::get('PUBLIC_PATH') . 'media/item/' . $size->name . '/' . $image);
                unlink(Path::get('PUBLIC_PATH') . 'media/item/' . $size->name . '/' . pathinfo($image)['filename'] . '.webp');
            }
        }
        return '';
    }
}
