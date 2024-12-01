<?php

namespace Image;

use Ivy\File;
use Ivy\Message;
use Ivy\Model;
use Ivy\Template;
use Random\RandomException;

class Image extends Model
{
    protected string $table = 'image';

    public int $id;
    public string $file;
    public string $token;

    public static function set($name, $value, $id = null): void
    {
        $image_info = strval(getimagesize(_PUBLIC_PATH . "media/item/thumb/" . $value)[3]);
        $image_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value);
        Template::render(_PLUGIN_PATH . 'image/template/input.TypeImage.latte', [
            'inputImage' => compact('name', 'value', 'id'),
            'image_info' => $image_info,
            'image_name' => $image_name
        ]);
    }
    
    public function upload($image): string
    {
        try {
            $file = new File;
            $file->name = bin2hex(random_bytes(16));
            $file->allowed = array('image/*');
            $image_sizes = new ImageSize;
            foreach ($image_sizes->get()->all() as $size) {
                $file->width = $size->value;
                $file->directory = _PUBLIC_PATH . '/media/item/' . $size->name;
                $file->image_convert = null;
                $this->file = $file->upload($image);
                $file->image_convert = 'webp';
                $this->file = $file->upload($image);
            }
        } catch (RandomException $e) {
            Message::add($e->getMessage());
        }

        return $this->file;
    }

    public function delete_set($file = null): void
    {
        $image = $file ?? $this->single()->file;
        $image_sizes = new ImageSize;
        foreach ($image_sizes->get()->all() as $size) {
            unlink(_PUBLIC_PATH . 'media/item/' . $size->name . '/' . $image);
            unlink(_PUBLIC_PATH . 'media/item/' . $size->name . '/' . pathinfo($image)['filename'] . '.webp');
        }
    }

}
