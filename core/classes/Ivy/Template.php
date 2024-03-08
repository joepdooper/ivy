<?php
namespace Ivy;

#[\AllowDynamicProperties]

class Template extends Model {

    protected $table = 'template';
    protected $path = _BASE_PATH . 'admin/template';

    public static array $css = array();
    public static array $js = array();
    public static array $esm = array();

    public static string $route;
    public static string $id;
    public static string $url = "";
    public static string $file;
    public static \stdClass $content;

    public static function setTemplateFile($file, $content = null): bool|string
    {
        if($content) {
            self::$content = $content;
        }
        if (file_exists(_TEMPLATE_SUB . $file)) {
            return _TEMPLATE_SUB . $file;
        } elseif(file_exists(_TEMPLATE_BASE . $file)) {
            return _TEMPLATE_BASE . $file;
        } elseif(file_exists($file)) {
            return $file;
        } else {
            return false;
        }
    }

    public static function addCSS($file): void
    {
        self::$css[] = $file;
    }

    public static function addJS($file): void
    {
        self::$js[] = $file;
    }

    public static function addESM($file): void
    {
        self::$esm[] = $file;
    }

}
