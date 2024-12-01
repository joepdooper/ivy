<?php

namespace Ivy;

use Hooks;
use Latte\Engine;

class Template extends Model
{
    protected string $table = 'template';
    protected string $path = _BASE_PATH . 'admin/template';

    public static array $css = array();
    public static array $js = array();
    public static array $esm = array();

    public static bool|string $file;

    public static string $route;
    public static string $id;
    public static string $url = "";

    private static ?Engine $latte = null;
    private static bool|string $name = '';
    private static array $params = [];
    private static ?string $block;
    private static ?Hooks $hooks = null;

    // -- file

    public static function file(string $file): bool|string
    {
        if (file_exists(_TEMPLATE_SUB . $file)) {
            self::$file = _TEMPLATE_SUB . $file;
        } elseif (file_exists(_TEMPLATE_BASE . $file)) {
            self::$file = _TEMPLATE_BASE . $file;
        } elseif (file_exists($file)) {
            self::$file = $file;
        } else {
            self::$file = false;
        }
        return self::$file;
    }

    // -- template rendering

    protected static function latte(string $name, object|array $params = [], ?string $block = null): void
    {
        if (self::$latte === null) {
            self::$latte = new Engine();
            self::$latte->addFunction('icon', function ($icon) {
                return file_get_contents(_PUBLIC_PATH . "/media/icon/" . $icon);
            });
            self::$latte->setTempDirectory(_PUBLIC_PATH . 'cache/templates');
        }
        self::$latte->render($name, $params, $block);
    }

    public static function name(string $name, object|array $params = [], ?string $block = null): bool|string
    {
        self::$name = self::file($name);
        self::$params = $params;
        self::$block = $block;
        return self::$name;
    }

    public static function view(string $name, object|array $params = [], ?string $block = null): void
    {
        self::name($name, $params, $block);
    }

    public static function render(string $name, object|array $params = [], ?string $block = null): void
    {
        self::latte(self::name($name), $params, $block);
    }

    public static function body(string $name, object|array $params = [], ?string $block = null): void
    {
        if (!self::$name) {
            self::name($name, $params, $block);
        }
        self::latte(self::$name, self::$params);
    }

    public static function head(string $name, object|array $params = [], ?string $block = null): void
    {
        if (file_exists(_TEMPLATE_SUB . $name)) {
            $name = _TEMPLATE_SUB . $name;
        } elseif (file_exists(_TEMPLATE_BASE . $name)) {
            $name = _TEMPLATE_BASE . $name;
        }
        self::latte($name, $params, $block);
    }

    // -- assets

    public static function addCSS($name): void
    {
        self::$css[] = self::file($name);
    }

    public static function addJS($name): void
    {
        self::$js[] = self::file($name);
    }

    public static function addESM($name): void
    {
        self::$esm[] = self::file($name);
    }

    // -- hooks

    public static function hooks(): Hooks
    {
        if (self::$hooks === null) {
            self::$hooks = new Hooks();
        }
        return self::$hooks;
    }

}
