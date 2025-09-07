<?php

namespace Items\Collection\Image;

use Items\Collection\Image\ImageSize;
use \Ivy\Abstract\File;
use Ivy\Core\Path;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageFile extends File
{
    protected ?int $imageWidth;

    public function getAllowedMimeTypes(): array
    {
        return ['image/jpeg', 'image/png', 'image/gif'];
    }

    public function getAllowedExtensions(): array
    {
        return ['jpg', 'jpeg', 'png', 'gif'];
    }

    public function getImageWidth(): int|null
    {
        return $this->imageWidth;
    }

    public function setImageWidth(?int $width = null): static
    {
        $this->imageWidth = $width;

        return $this;
    }

    public function remove(?string $fileName = null): void
    {
        if($fileName){
            unlink(Path::get('MEDIA_PATH') . trim($this->getUploadPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName);
            unlink(Path::get('MEDIA_PATH') . trim($this->getUploadPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . pathinfo($fileName)['filename'] . '.webp');
        }
    }
}
