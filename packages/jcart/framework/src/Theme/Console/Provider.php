<?php

namespace Jcart\Framework\Theme\Console;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMakeTheme();
    }

    /**
     * Register the command.
     *
     * @return void
     */
    protected function registerMakeTheme()
    {
        $this->app->singleton('command.jcart.theme.make', function ($app) {
            return new ThemeMakeCommand($app['files']);
        });

        $this->commands(['command.jcart.theme.make']);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.jcart.theme.make'];
    }
}
