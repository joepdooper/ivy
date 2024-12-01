<?php
namespace Code;

use Ivy\Model;
use Ivy\Template;
use HTMLPurifier_Config;
use HTMLPurifier;

class Item extends Model
{
    public int $id;
    public string $text;
    private string $token;

    protected string $table = "code";

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

?>
