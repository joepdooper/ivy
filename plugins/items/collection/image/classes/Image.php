<?php

namespace Items\Collections\Image;

use Ivy\File;
use Ivy\Model;
use Ivy\Path;
use Ivy\Template;
use Random\RandomException;

class Image extends Model
{
    protected string $table = 'image';
    protected array $columns = [
        'file'
    ];
    private string $file;

    public static function set($name, $value, $id = null): void
    {
        $image_info = strval(getimagesize(Path::get('PUBLIC_PATH') . "media/item/thumb/" . $value)[3]);
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
            $file->setName(bin2hex(random_bytes(16)));
            $file->setAllowed(array('image/*'));
            foreach ((new ImageSize)->fetchAll() as $size) {
                $file->setWidth($size->value);
                $file->setDirectory(Path::get('PUBLIC_PATH') . '/media/item/' . $size->name);
                $this->file = $file->upload($image);
                $file->setImageConvert( 'webp');
                $this->file = $file->upload($image);
            }
        } catch (RandomException $e) {
            Message::add($e->getMessage());
        }

        return $this->file;
    }

    public function deleteSet(?string $file = null): void
    {
        $image = $file ?? $this->fetchOne()->file;
        foreach ((new ImageSize)->fetchAll() as $size) {
            unlink(Path::get('PUBLIC_PATH') . 'media/item/' . $size->getName() . '/' . $image);
            unlink(Path::get('PUBLIC_PATH') . 'media/item/' . $size->getName() . '/' . pathinfo($image)['filename'] . '.webp');
        }
    }

    public function getFile(): string
    {
        return $this->file;
    }

    public function setFile(string $file): void
    {
        $this->file = $file;
    }

}
