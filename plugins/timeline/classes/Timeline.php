<?php

namespace Timeline;

use HTMLPurifier_Config;
use HTMLPurifier;
use Ivy\Abstract\Model;

class Timeline extends Model
{
    protected string $table = "timeline";
    protected array $columns = [
        'datetime',
        'token'
    ];

    protected string $datetime;
    protected ?string $token;

    public function purify($array)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.AllowedElements', array('br', 'ul', 'ol', 'li', 'b', 'i'));
        $purifier = new HTMLPurifier($config);
        foreach ($array as $key => $value) {
            if ($value) {
                $array[$key] = $purifier->purify($value);
            }
        }
        return $array;
    }

}
