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
    public static ?string $file;
    public static array $positions = array();
    public static mixed $content;

    public static function file($file, $content = null, $position = null): bool|string
    {
        if (file_exists(_TEMPLATE_SUB . $file)) {
            self::$file = _TEMPLATE_SUB . $file;
        } elseif(file_exists(_TEMPLATE_BASE . $file)) {
            self::$file = _TEMPLATE_BASE . $file;
        } elseif(file_exists($file)) {
            self::$file = $file;
        } else {
            self::$file = false;
        }
        if($content) {
            self::$content = $content;
        }
        if($position) {
            self::$positions[$position]['file'] = self::$file;
            self::$positions[$position]['content'] = $content;
        }
        return self::$file;
    }

    public static function position($position, $content = null): string|bool
    {
        if($content){
            self::$positions[$position]['content'] = $content;
        }
        if (array_key_exists($position, self::$positions)) {
            return self::file(self::$positions[$position]['file'], self::$positions[$position]['content']);
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
