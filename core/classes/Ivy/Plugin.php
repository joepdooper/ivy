<?php

namespace Ivy;

use Exception;

class Plugin extends Model
{
    protected string $table = 'plugin';
    protected string $path = _BASE_PATH . 'admin/plugin';
    private ?int $id;
    private ?string $url;
    private PluginInfo $info;

    public function __construct($data = null)
    {
        parent::__construct();
        $this->id = $data['id'] ?? null;
        $this->url = $data['url'] ?? null;
    }

    public function setInfo(): Plugin
    {
        $this->info = new PluginInfo($this->url);

        return $this;
    }

    public function setUrl($url): Plugin
    {
        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function hasUrl(): bool
    {
        return (bool)$this->url;
    }


    public function setId($id): Plugin
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function hasId(): bool
    {
        return (bool)$this->id;
    }

    public function checkDependencies(): array
    {
        $dependencies = [];
        if (isset($this->info->dependencies)) {
            $dependencies = array_filter($this->info->dependencies, function ($dependency) {
                return !DB::$connection->selectValue('SELECT id FROM plugin WHERE name = :name', ['name' => $dependency]);
            });
        }

        return $dependencies;
    }

    public function install(): void
    {
        try {
            if (!empty($missing = $this->checkDependencies())) {
                $count = count($missing);
                $message = "This plugin has " . ($count > 1 ? "dependencies" : "dependency") . ". Please install the " . ($count > 1 ? "plugins" : "plugin") . " " . implode(", ", $missing);
                Message::add($message, _BASE_PATH . 'admin/plugin');
            }
            if (isset($this->info->database['install']) && !empty($this->info->database['install']) && !empty($this->info->url)) {
                if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $this->info->url . DIRECTORY_SEPARATOR . $this->info->database['install'])) {
                    require_once _PUBLIC_PATH . _PLUGIN_PATH . $this->info->url . DIRECTORY_SEPARATOR . $this->info->database['install'];
                }
                unset($this->info->database);
            }
            $this->insert((array)$this->info);
        } catch (Exception $e) {
            Message::add("Error installing plugin: " . $e->getMessage());
        }
    }

    public function uninstall(): void
    {
        try {
            $this->setUrl($this->data->url)->setInfo();
            if (isset($this->info->database['uninstall']) && !empty($this->info->database['uninstall'])) {
                if (file_exists(_PUBLIC_PATH . _PLUGIN_PATH . $this->info->url . DIRECTORY_SEPARATOR . $this->info->database['uninstall'])) {
                    require_once _PUBLIC_PATH . _PLUGIN_PATH . $this->info->url . DIRECTORY_SEPARATOR . $this->info->database['uninstall'];
                }
            }
            $this->delete();
        } catch (Exception $e) {
            Message::add("Error uninstalling plugin: " . $e->getMessage());
        }
    }

}
