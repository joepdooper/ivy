<?php

namespace Items;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;
use Ivy\Core\Contracts\PluginInterface;
use Ivy\Core\Path;
use Ivy\Manager\AssetManager;
use Ivy\Routing\Route;

class ItemInterface implements PluginInterface
{
    public function register(): void
    {
        Route::get('/', '\Items\ItemController@index')
            ->before('\Ivy\Controller\AdminController@before');

        Route::mount('/item', function () {
            Route::post('/save/(\d+)', '\Items\ItemController@save')
                ->before('\Ivy\Controller\AdminController@before');
            Route::post('/update/(\d+)', '\Tags\TagController@update')
                ->before('\Ivy\Controller\AdminController@before');
            Route::post('/insert', '\Tags\TagController@insert')
                ->before('\Ivy\Controller\AdminController@before');
        });
    }

    public function install(): void
    {
        if (!Capsule::schema()->hasTable('items')) {
            Capsule::schema()->create('items', function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('user_id')->nullable()->index('user_id');
                $table->unsignedInteger('parent_id')->nullable();
                $table->integer('publish')->nullable();
                $table->integer('token')->nullable();
                $table->dateTime('date')->useCurrent();
                $table->integer('sort')->nullable();
                $table->string('slug', 255)->nullable();
            });
        }

        $mediaPath = Path::get('MEDIA_PATH') . 'items';

        if (!is_dir($mediaPath)) {
            mkdir($mediaPath, 0755, true);

            file_put_contents(
                $mediaPath . '/.htaccess',
                "Options -Indexes\n<FilesMatch \"\.(php|php5|phtml|js)$\">\nDeny from all\n</FilesMatch>"
            );

            file_put_contents(
                $mediaPath . '/index.php',
                '<?php // Silence is golden'
            );
        }
    }

    public function uninstall(): void
    {
        if (Capsule::schema()->hasTable('items')) {
            Capsule::schema()->drop('items');
        }

//        $mediaPath = Path::get('MEDIA_PATH') . 'items';

//        if (is_dir($mediaPath)) {
//            deleteDirectory($mediaPath);
//        }

//        function deleteDirectory(string $dir): void
//        {
//            foreach (scandir($dir) as $item) {
//                if ($item === '.' || $item === '..') {
//                    continue;
//                }
//
//                $path = $dir . DIRECTORY_SEPARATOR . $item;
//
//                if (is_dir($path)) {
//                    deleteDirectory($path);
//                } else {
//                    unlink($path);
//                }
//            }
//
//            rmdir($dir);
//        }
    }
}