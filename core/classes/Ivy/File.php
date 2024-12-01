<?php

namespace Ivy;

use Verot\Upload\Upload;

class File
{
    public string $directory;
    public string $name;
    public string $file_name;
    public string $format;
    public array $allowed;
    public ?string $image_convert;
    public ?int $width;

    // upload
    function upload($file): string
    {
        $handle = new Upload($file);
        $handle->allowed = $this->allowed;
        if ($handle->file_is_image) {
            !$this->image_convert ?: $handle->image_convert = $this->image_convert;
            if ($this->width) {
                $handle->image_resize = true;
                $handle->image_x = $this->width;
                $handle->image_ratio_y = true;
            }
        }
        $handle->file_new_name_body = $this->name;
        $handle->process($this->directory);
        if ($handle->processed) {
            $this->file_name = $this->name . '.' . $handle->file_src_name_ext;
            // $handle->clean();
        } else {
            Message::add('error : ' . $handle->error);
        }
        return $this->file_name;
    }
}
