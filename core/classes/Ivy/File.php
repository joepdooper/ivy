<?php
namespace Ivy;

use Verot\Upload\Upload;

class File {

    public $directory, $name, $format, $allowed, $image_convert, $width;

    // upload
    function upload($file): string
    {
        $name = "";
        $handle = new Upload($file);
        $handle->allowed = $this->allowed;
        !$this->image_convert ?: $handle->image_convert = $this->image_convert;
        if($this->width && $handle->file_is_image){
            $handle->image_resize = true;
            $handle->image_x = $this->width;
            $handle->image_ratio_y = true;
        }
        $handle->file_new_name_body = $this->name;
        $handle->process($this->directory);
        if ($handle->processed) {
            $name = $this->name . '.' . $handle->file_src_name_ext;
            // $handle->clean();
        } else {
            Message::add('error : ' . $handle->error);
        }
        return $name;
    }

}
