<?php

namespace Items\Collection\Image;

use Ivy\Abstract\File;
use Ivy\Core\Path;
use RuntimeException;

class ImageFile extends File
{
    public function getUploadPath(): string|array
    {
        return 'item/images';
    }

    public function getAllowedMimeTypes(): array
    {
        return ['image/jpeg', 'image/png', 'image/gif'];
    }

    public function getAllowedExtensions(): array
    {
        return ['jpg', 'jpeg', 'png', 'gif'];
    }

    protected function upload(): void
    {
        $tmpPath = $this->uploadFile->getPathname();
        [$origWidth, $origHeight, $type] = getimagesize($tmpPath);

        if (!$origWidth || !$origHeight) {
            throw new RuntimeException("Failed to read image dimensions");
        }

        switch ($type) {
            case IMAGETYPE_JPEG: $src = imagecreatefromjpeg($tmpPath); break;
            case IMAGETYPE_PNG:  $src = imagecreatefrompng($tmpPath); break;
            case IMAGETYPE_GIF:  $src = imagecreatefromgif($tmpPath); break;
            default: throw new RuntimeException("Unsupported image type");
        }

        foreach ((new ImageSize)->fetchAll() as $size) {
            $targetDir = Path::get('MEDIA_PATH') . DIRECTORY_SEPARATOR . 'item' . DIRECTORY_SEPARATOR . $size->name;
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $this->fileName;

            if (empty($size->value)) {
                copy($tmpPath, $targetPath);
                $webpPath = $targetDir . DIRECTORY_SEPARATOR . pathinfo($this->fileName, PATHINFO_FILENAME) . '.webp';
                imagewebp($src, $webpPath, 80);
                continue;
            }

            $maxWidth  = (int) $size->value;
            $ratio     = $origWidth / $origHeight;
            $newWidth  = $maxWidth;
            $newHeight = (int) round($maxWidth / $ratio);

            $dst = imagecreatetruecolor($newWidth, $newHeight);

            if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_GIF], true)) {
                imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
            }

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

            switch ($type) {
                case IMAGETYPE_JPEG: imagejpeg($dst, $targetPath, 90); break;
                case IMAGETYPE_PNG:  imagepng($dst, $targetPath, 8); break;
                case IMAGETYPE_GIF:  imagegif($dst, $targetPath); break;
            }

            $webpPath = $targetDir . DIRECTORY_SEPARATOR . pathinfo($this->fileName, PATHINFO_FILENAME) . '.webp';
            imagewebp($dst, $webpPath, 80);

            imagedestroy($dst);
        }

        imagedestroy($src);
    }

    public function remove($file):void
    {
        if($file){
            foreach ((new ImageSize)->fetchAll() as $size) {
                unlink(Path::get('MEDIA_PATH') . $size->name . DIRECTORY_SEPARATOR . $file);
                unlink(Path::get('MEDIA_PATH') . $size->name . '/' . pathinfo($file)['filename'] . '.webp');
            }
        }
    }
}