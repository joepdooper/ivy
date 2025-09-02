<?php

namespace Items\Collection\Image;

use Ivy\Abstract\File;
use Ivy\Core\Path;
use RuntimeException;

class ImageFile extends File
{
    /**
     * Where images are uploaded
     */
    public function getUploadPath(): string|array
    {
        return 'item/images';
    }

    /**
     * Allowed MIME types
     */
    public function getAllowedMimeTypes(): array
    {
        return ['image/jpeg', 'image/png', 'image/gif'];
    }

    /**
     * Allowed extensions
     */
    public function getAllowedExtensions(): array
    {
        return ['jpg', 'jpeg', 'png', 'gif'];
    }

    /**
     * Resize the uploaded image and generate a WebP copy.
     *
     * @param int|null $maxWidth
     * @param int|null $maxHeight
     * @return $this
     */
    public function resize(?int $maxWidth = null, ?int $maxHeight = null): static
    {
        $source = Path::get('MEDIA_PATH') . DIRECTORY_SEPARATOR . trim($this->getUploadPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $this->fileName;

        [$origWidth, $origHeight, $type] = getimagesize($source);

        if (!$origWidth || !$origHeight) {
            throw new RuntimeException("Failed to get image size");
        }

        // Calculate new size preserving aspect ratio
        $ratio = $origWidth / $origHeight;

        if ($maxWidth && $maxHeight) {
            $newWidth = $maxWidth;
            $newHeight = $maxHeight;
        } elseif ($maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) round($maxWidth / $ratio);
        } elseif ($maxHeight) {
            $newHeight = $maxHeight;
            $newWidth = (int) round($maxHeight * $ratio);
        } else {
            return $this; // no resizing requested
        }

        // Load source image
        switch ($type) {
            case IMAGETYPE_JPEG: $src = imagecreatefromjpeg($source); break;
            case IMAGETYPE_PNG:  $src = imagecreatefrompng($source); break;
            case IMAGETYPE_GIF:  $src = imagecreatefromgif($source); break;
            default: throw new RuntimeException("Unsupported image type");
        }

        // Create destination canvas
        $dst = imagecreatetruecolor($newWidth, $newHeight);

        // Preserve transparency for PNG & GIF
        if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_GIF], true)) {
            imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $origWidth, $origHeight);

        // Overwrite original image
        switch ($type) {
            case IMAGETYPE_JPEG: imagejpeg($dst, $source, 90); break;
            case IMAGETYPE_PNG:  imagepng($dst, $source, 8); break;
            case IMAGETYPE_GIF:  imagegif($dst, $source); break;
        }

        // Save WebP version
        $webpFileName = pathinfo($this->fileName, PATHINFO_FILENAME) . '.webp';
        $webpPath = Path::get('MEDIA_PATH') . DIRECTORY_SEPARATOR . trim($this->getUploadPath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $webpFileName;
        imagewebp($dst, $webpPath, 80);

        imagedestroy($src);
        imagedestroy($dst);

        return $this;
    }
}