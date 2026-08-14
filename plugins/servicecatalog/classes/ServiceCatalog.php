<?php

namespace ServiceCatalog;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Plugin\Application\Contracts\PluginInterface;
use Ivy\Shared\Presentation\Routing\Route;
use Ivy\User\Domain\Entity\Profile;

class ServiceCatalogInterface implements PluginInterface
{
    public function register(): void
    {

    }

    public function install(): void
    {

    }

    public function uninstall(): void
    {
    }
}