<?php
namespace Items\Collection\Image;

use Ivy\Core\Path;

trait ImageProcess
{
    /**
     * Resize an uploaded image (with WebP copy).
     * Works with single or multiple sizes and/or target paths.
     *
     * @param int|int[]|null $maxWidth
     * @param int|int[]|null $maxHeight
     * @return self
     */
    protected function resizeImage(int|array|null $maxWidth = null, int|array|null $maxHeight = null): self
    {
        if (!$this->fileName) {
            return $this;
        }

        $widths = is_array($maxWidth) ? $maxWidth : [$maxWidth];
        $heights = is_array($maxHeight) ? $maxHeight : [$maxHeight];
        $paths = is_array($this->uploadMediaPath) ? $this->uploadMediaPath : [$this->uploadMediaPath];

        $sourcePath = Path::get('MEDIA_PATH')
            . trim(is_array($this->uploadMediaPath) ? $this->uploadMediaPath[0] : $this->uploadMediaPath, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . $this->fileName;

        [$origWidth, $origHeight, $type] = getimagesize($sourcePath);
        if (!$origWidth || !$origHeight) {
            return $this;
        }

        switch ($type) {
            case IMAGETYPE_JPEG: $src = imagecreatefromjpeg($sourcePath); break;
            case IMAGETYPE_PNG:  $src = imagecreatefrompng($sourcePath); break;
            case IMAGETYPE_GIF:  $src = imagecreatefromgif($sourcePath); break;
            default: return $this;
        }

        foreach ($widths as $w) {
            foreach ($heights as $h) {
                foreach ($paths as $path) {
                    if (!$w && !$h) {
                        continue;
                    }

                    $ratio = $origWidth / $origHeight;
                    if ($w && $h) {
                        $newWidth = $w;
                        $newHeight = $h;
                    } elseif ($w) {
                        $newWidth = $w;
                        $newHeight = (int) round($w / $ratio);
                    } elseif ($h) {
                        $newHeight = $h;
                        $newWidth = (int) round($h * $ratio);
                    } else {
                        continue;
                    }

                    $dst = imagecreatetruecolor($newWidth, $newHeight);
                    if (in_array($type, [IMAGETYPE_PNG, IMAGETYPE_GIF], true)) {
                        imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
                        imagealphablending($dst, false);
                        imagesavealpha($dst, true);
                    }

                    imagecopyresampled($dst, $src, 0,0,0,0, $newWidth, $newHeight, $origWidth, $origHeight);

                    $targetDir = Path::get('MEDIA_PATH') . trim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
                    if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0777, true);
                    }

                    $targetPath = $targetDir . $this->fileName;
                    switch ($type) {
                        case IMAGETYPE_JPEG: imagejpeg($dst, $targetPath, 90); break;
                        case IMAGETYPE_PNG:  imagepng($dst, $targetPath, 8); break;
                        case IMAGETYPE_GIF:  imagegif($dst, $targetPath); break;
                    }

                    $webpPath = $targetDir . pathinfo($this->fileName, PATHINFO_FILENAME) . '.webp';
                    imagewebp($dst, $webpPath, 80);

                    imagedestroy($dst);
                }
            }
        }

        imagedestroy($src);

        return $this;
    }
}
