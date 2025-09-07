<?php

namespace Items\Collection\Image;

use Ivy\Core\Path;
use Ivy\Model\User;
use Ivy\Service\FileService;

class ImageFileService extends FileService
{
    /** @var ImageFile[] */
    protected array $files = [];

    public function upload(): void
    {
        if(!User::getAuth()->isLoggedIn()){
            throw new \RuntimeException('You must be logged in to upload files.');
        }

        foreach ($this->files as $file){
            $file->validate();

            if (!$file->getFileName()) {
                $file->generateFileName();
            }

            $tmpPath = $file->getUploadFile()->getPathname();
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

            $targetDir = Path::get('MEDIA_PATH') . DIRECTORY_SEPARATOR . trim($file->getUploadPath(), DIRECTORY_SEPARATOR);
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }

            $targetPath = $targetDir . DIRECTORY_SEPARATOR . $file->getFileName();

            if (empty($file->getImageWidth())) {
                copy($tmpPath, $targetPath);
                $webpPath = $targetDir . DIRECTORY_SEPARATOR . pathinfo($file->getFileName(), PATHINFO_FILENAME) . '.webp';
                imagewebp($src, $webpPath, 80);
                continue;
            }

            $maxWidth  = (int) $file->getImageWidth();
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

            $webpPath = $targetDir . DIRECTORY_SEPARATOR . pathinfo($file->getFileName(), PATHINFO_FILENAME) . '.webp';
            imagewebp($dst, $webpPath, 80);

            imagedestroy($dst);
        }

        imagedestroy($src);
    }
}
