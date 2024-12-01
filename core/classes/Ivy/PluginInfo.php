<?php

namespace Ivy;

use HTMLPurifier;
use HTMLPurifier_Config;

class PluginInfo
{
    public ?string $name;
    public ?string $version;
    public ?string $description;
    public ?string $url;
    public ?string $type;
    public ?array $dependencies;
    public bool $settings;
    public ?array $database;

    public function __construct(string $url)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        $dir = _PUBLIC_PATH . _PLUGIN_PATH . $purifier->purify($url) . DIRECTORY_SEPARATOR;
        $url = realpath($dir . 'info.json');

        if ($url) {
            if (str_starts_with($url, $dir)) {
                $data = json_decode(file_get_contents($url), true);
                $this->name = isset($data['name']) ? $purifier->purify($data['name']) : null;
                $this->url = isset($data['url']) ? $purifier->purify($data['url']) : null;
                $this->version = isset($data['version']) ? $purifier->purify($data['version']) : null;
                $this->settings = $data['settings'] ?? false;
                $this->description = isset($data['description']) ? $purifier->purify($data['description']) : null;
                $this->type = isset($data['type']) ? $purifier->purify($data['type']) : null;
                $this->database = $data['database'] ?? null;
            }
        }
    }
}
