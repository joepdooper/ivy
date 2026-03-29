<?php

namespace Items\Collection\Code;

use HTMLPurifier;
use HTMLPurifier_Config;
use Ivy\Abstract\Model;

class Code extends Model
{
    protected string $table = 'codes';

    protected array $columns = [
        'code',
        'language',
        'token',
    ];

    protected ?string $code;

    protected string $language;

    protected ?string $token;

    public function purify($array)
    {
        $config = HTMLPurifier_Config::createDefault();
        $config->set('HTML.AllowedElements', ['br', 'ul', 'ol', 'li', 'b', 'i']);
        $purifier = new HTMLPurifier($config);
        foreach ($array as $key => $value) {
            if ($value) {
                $array[$key] = $purifier->purify($value);
            }
        }

        return $array;
    }
}
