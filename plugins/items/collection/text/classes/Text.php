<?php

namespace Items\Collection\Text;

use HTMLPurifier_Config;
use HTMLPurifier;
use Ivy\Abstract\Model;

class Text extends Model
{
    protected string $table = "text";
    protected array $columns = [
        'text',
        'token'
    ];

    protected string $text;
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
