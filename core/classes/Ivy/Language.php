<?php

namespace Ivy;

class Language
{
    protected static string $defaultLang = 'en';
    protected static array $translations = [];
    protected static array $loadedFiles = [];

    public static function load($lang = null): void
    {
        if (!$lang) {
            $lang = self::$defaultLang;
        }

        self::$defaultLang = $lang;
    }

    public static function get($key)
    {
        $keys = explode('.', $key);
        $fileKey = array_shift($keys);

        if (!isset(self::$loadedFiles[$fileKey])) {
            self::loadFile($fileKey);
        }

        $translation = self::$translations[$fileKey] ?? null;

        foreach ($keys as $k) {
            if (is_array($translation) && isset($translation[$k])) {
                $translation = $translation[$k];
            } else {
                return $key;
            }
        }

        return $translation;
    }

    protected static function loadFile($fileKey): void
    {
        $langPath = _ROOT . _SUBFOLDER . 'language/' . self::$defaultLang . '/' . $fileKey . '.php';

        if (file_exists($langPath)) {
            self::$translations[$fileKey] = include $langPath;
            self::$loadedFiles[$fileKey] = true;
        } else {
            self::$translations[$fileKey] = [];
            self::$loadedFiles[$fileKey] = false;
        }
    }

    public static function setDefaultLang($lang): void
    {
        self::$defaultLang = $lang;
    }
}
