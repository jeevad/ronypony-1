<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ImageService;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerImageService();

        $this->app->alias('image', 'App\Services\ImageService');
    }

    /**
     * Register the Image Service instance.
     *
     * @return void
     */
    protected function registerImageService()
    {
        $this->app->singleton('image', function ($app) {
            return new ImageService();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['image', 'App\Services\ImageService'];
    }
}
