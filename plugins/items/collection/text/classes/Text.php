<?php

namespace Text;

use Ivy\Model;
use Ivy\Template;
use HTMLPurifier_Config;
use HTMLPurifier;

class Text extends Model
{

    public int $id;
    public string $text;
    public string $token;

    protected string $table = "text";

    public static function set($name, $value, $id = null): void
    {
        Template::render(_PLUGIN_PATH . 'text/template/input.TypeText.latte', [
            'inputText' => compact('name', 'value', 'id')
        ]);
    }

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
