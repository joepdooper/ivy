<?php
namespace Items\Collection\Code;

use Ivy\Abstract\Model;
use HTMLPurifier_Config;
use HTMLPurifier;

class Code extends Model
{
    protected string $table = "code";
    protected array $columns = [
        'code',
        'language',
        'token'
    ];

    protected ?string $code;
    protected string $language;
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
