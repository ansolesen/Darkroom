<?php

namespace Dresing\Darkroom;

use Dresing\Darkroom\FileManager\FileCreator;
use Dresing\Darkroom\FileManagers\FileManager;
use Dresing\Darkroom\ImageGenerators\ImageGenerator;
use Dresing\Darkroom\PathGenerator\BasePathGenerator;
use Dresing\Darkroom\PathGenerator\PathGenerator;
use Dresing\Darkroom\Requests\CreateRequest;
use Dresing\Darkroom\Requests\DeleteRequest;
use Dresing\Darkroom\Requests\GetRequest;
use Illuminate\Support\ServiceProvider;

class DarkroomServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/darkroom.php', 'darkroom'
        );

        $this->app->singleton(FileManager::class, function ($app) {
            $fileManager = config('darkroom.file_manager');
            return new $fileManager();
        });

        $this->app->singleton(CreateRequest::class, function ($app) {
            return new CreateRequest(config('darkroom.disk_name'));
        });
        $this->app->singleton(GetRequest::class, function ($app) {
            return new GetRequest(config('darkroom.disk_name'));
        });
        $this->app->singleton(DeleteRequest::class, function ($app) {
            return new DeleteRequest(config('darkroom.disk_name'));
        });
        $this->app->singleton(PathGenerator::class, function ($app) {
            $pathGenerator = config('darkroom.path_generator');
            return new $pathGenerator();
        });

        $this->app->singleton(ImageGenerator::class, function ($app) {
            $imageGenerator = config('darkroom.image_generator');
            return new $imageGenerator();
        });

    }
}
