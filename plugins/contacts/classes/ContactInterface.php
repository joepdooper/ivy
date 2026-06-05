<?php

namespace Contacts;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Plugin\Application\Contracts\PluginInterface;
use Ivy\Shared\Presentation\Routing\Route;
use Ivy\Template\Infrastructure\Manager\AssetManager;
use Ivy\User\Application\Service\AuthService;

class ContactInterface implements PluginInterface
{
    public function register(AuthService $auth): void
    {
        Route::mount('/admin/plugin/contacts', function () {
            Route::get('/index', '\Contacts\ContactController@index')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
            Route::post('/sync', '\Contacts\ContactController@sync')
                ->before('\Ivy\User\Presentation\Controller\AdminController@before');
        });

//        if ($auth->canEditAsEditor()) {
//            AssetManager::addJS('plugins/contacts/js/contacts.admin.js');
//        }
    }

    public function install(): void
    {
        Capsule::schema()->create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->string('email', 255)->nullable();
            $table->date('birthday')->nullable();
            $table->integer('profile_id')->nullable();
            $table->timestamps();
        });
    }

    public function uninstall(): void
    {
        Capsule::schema()->dropIfExists('contacts');
    }
}