<?php

namespace Moments;

use Ivy\Plugin\Application\Contracts\PluginInterface;

class MomentInterface implements PluginInterface
{
    public function register(): void {}

    public function install(): void {}

    public function uninstall(): void {}
}
