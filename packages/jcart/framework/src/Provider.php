<?php

namespace Jcart\Framework;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Jcart\Framework\Models\Database\Product;
use Jcart\Framework\Api\Middleware\AdminApiAuth;
use Jcart\Framework\User\Middleware\AdminAuth;
use Jcart\Framework\User\Middleware\RedirectIfAdminAuth;
use Jcart\Framework\User\Middleware\Permission;
use Jcart\Framework\System\Middleware\SiteCurrencyMiddleware;
use Jcart\Framework\User\ViewComposers\AdminUserFieldsComposer;
use Jcart\Framework\System\ViewComposers\AdminNavComposer;
use Jcart\Framework\Product\ViewComposers\CategoryFieldsComposer;
use Jcart\Framework\Product\ViewComposers\ProductFieldsComposer;
use Jcart\Framework\Cms\ViewComposers\PageFieldsComposer;
use Jcart\Framework\User\ViewComposers\UserFieldsComposer;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Carbon;
use Laravel\Passport\Console\InstallCommand;
use Laravel\Passport\Console\ClientCommand;
use Laravel\Passport\Console\KeysCommand;
use Jcart\Framework\User\ViewComposers\SiteCurrencyFieldsComposer;
use Jcart\Framework\Cms\ViewComposers\MenuComposer;

class Provider extends ServiceProvider
{
    protected $providers = [
        // \Jcart\Framework\AdminMenu\AdminMenuProvider::class,
        // \Jcart\Framework\AdminConfiguration\Provider::class,
        // \Jcart\Framework\Breadcrumb\BreadcrumbProvider::class,
        \Jcart\Framework\Cart\Provider::class,
        // \Jcart\Framework\DataGrid\Provider::class,
        \Jcart\Framework\Image\Provider::class,
        // \Jcart\Framework\Menu\Provider::class,
        // \Jcart\Framework\Models\ModelProvider::class,
        // \Jcart\Framework\Modules\Provider::class,
        \Jcart\Framework\Payment\Provider::class,
        \Jcart\Framework\Permission\Provider::class,
        \Jcart\Framework\Shipping\Provider::class,
        \Jcart\Framework\Tabs\Provider::class,
        \Jcart\Framework\Theme\Provider::class,
        // \Jcart\Framework\Widget\WidgetProvider::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->registerMiddleware();
        // $this->registerViewComposerData();
        // $this->registerResources();
        // $this->registerPassportResources();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->registerConfigData();
        // Passport::ignoreMigrations();
        $this->registerProviders();
    }

    /**
     * Registering Jcart E commerce Services
     * e.g Admin Menu.
     *
     * @return void
     */
    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            App::register($provider);
        }
    }

    /**
     * Register Jcart Framework Resources here.
     * @return void
     */
    public function registerResources()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'jcart-framework');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'jcart-framework');
        //At this stage we don't use these and use jcart/framework/database/migration file only
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function registerConfigData()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/jcart-framework.php', 'jcart-framework');

        $jcartConfigData = include __DIR__ . '/../config/jcart-framework.php';

        $fileSystemConfig = $this->app['config']->get('filesystems', []);
        $authConfig = $this->app['config']->get('auth', []);
        $this->app['config']->set(
            'filesystems',
            array_merge_recursive($jcartConfigData['filesystems'], $fileSystemConfig)
        );
        $this->app['config']->set(
            'auth',
            array_merge_recursive($jcartConfigData['auth'], $authConfig)
        );
        $authConfig = $this->app['config']->get('auth', []);
        
    }

    public function publishFiles()
    {
        $this->publishes([
            __DIR__ . '/../config/jcart-framework.php' => config_path('jcart-framework.php'),
        ]);
    }

    /**
     * Registering Jcart E commerce Middleware.
     *
     * @return void
     */
    protected function registerMiddleware()
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('admin.auth', AdminAuth::class);
        $router->aliasMiddleware('admin.guest', RedirectIfAdminAuth::class);
        $router->aliasMiddleware('permission', Permission::class);

        $router->aliasMiddleware('currency', SiteCurrencyMiddleware::class);
        $router->aliasMiddleware('admin.api.auth', AdminApiAuth::class);
    }

    /**
     * Registering Class Based View Composer.
     *
     * @return void
     */
    public function registerViewComposerData()
    {
        View::composer('jcart-framework::layouts.left-nav', AdminNavComposer::class);
        View::composer('jcart-framework::user.user._fields', UserFieldsComposer::class);
        View::composer('jcart-framework::system.site-currency._fields', SiteCurrencyFieldsComposer::class);
        View::composer(['jcart-framework::product.category._fields'], CategoryFieldsComposer::class);
        View::composer(['jcart-framework::system.admin-user._fields'], AdminUserFieldsComposer::class);
        View::composer('jcart-framework::cms.page._fields', PageFieldsComposer::class);
        View::composer('jcart-framework::cms.menu.index', MenuComposer::class);
        View::composer(['jcart-framework::product.create',
                        'jcart-framework::product.edit',
                        ], ProductFieldsComposer::class);
    }

    /*
    *  Registering Passport Oauth2.0 client
    *
    * @return void
    */
    public function registerPassportResources()
    {
        Passport::ignoreMigrations();
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addDays(15));
        $this->commands([
          InstallCommand::class,
          ClientCommand::class,
          KeysCommand::class,
      ]);
    }
}
