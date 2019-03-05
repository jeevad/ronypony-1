<?php

namespace Jcart\Framework\Theme;

use Illuminate\Support\ServiceProvider;
use Jcart\Framework\Theme\Facade as Theme;

class Provider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerTheme();
        $this->app->alias('theme', 'Jcart\Framework\Theme\Manager');

        $this->registerThemeConsoleProvider();

        $themes = Theme::all();
    }

    /**
     * Register the AdmainConfiguration instance.
     *
     * @return void
     */
    protected function registerTheme()
    {
        $this->app->singleton('theme', function ($app) {
            $loadDefaultLangPath = base_path('themes/jcart/default/lang');
            $app['path.lang'] = $loadDefaultLangPath;

            return new Manager($app['files']);
        });
    }

    /*
     * Register Module console Command which Register most Module generation Command
     *
     * @return void
     */
    public function registerThemeConsoleProvider()
    {
        $this->app->register('Jcart\Framework\Theme\Console\Provider');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['theme', 'Jcart\Framework\Theme\Manager'];
    }
}
