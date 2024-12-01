<?php

namespace Image;

use Ivy\Model;

class ImageSize extends Model
{

    protected string $table = 'image_sizes';
    protected string $path = _BASE_PATH . 'plugin/image';

    public function save($array): bool|int|string|null
    {
        if (isset($array['value'])) {
            $array['value'] = !empty($array['value']) ? (int)$array['value'] : null;
        }
        return parent::save($array);
    }

}
