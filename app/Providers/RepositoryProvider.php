<?php

namespace App\Providers;

use App\Contracts\Repository\AdminUserInterface;
use App\Contracts\Repository\AttributeInterface;
use App\Contracts\Repository\CategoryFilterInterface;
use App\Contracts\Repository\CategoryInterface;
use App\Contracts\Repository\ConfigurationInterface;
use App\Contracts\Repository\CountryInterface;
use App\Contracts\Repository\MenuInterface;
use App\Contracts\Repository\OrderHistoryInterface;
use App\Contracts\Repository\OrderInterface;
use App\Contracts\Repository\OrderStatusInterface;
use App\Contracts\Repository\PageInterface;
use App\Contracts\Repository\ProductDownloadableUrlInterface;
use App\Contracts\Repository\ProductInterface;
use App\Contracts\Repository\PropertyInterface;
use App\Contracts\Repository\RoleInterface;
use App\Contracts\Repository\SiteCurrencyInterface;
use App\Contracts\Repository\StateInterface;
use App\Contracts\Repository\UserGroupInterface;
use App\Contracts\Repository\UserInterface;
use App\Repositories\AdminUserRepository;
use App\Repositories\AttributeRepository;
use App\Repositories\CategoryFilterRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ConfigurationRepository;
use App\Repositories\CountryRepository;
use App\Repositories\MenuRepository;
use App\Repositories\OrderHistoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderStatusRepository;
use App\Repositories\PageRepository;
use App\Repositories\ProductDownloadableUrlRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PropertyRepository;
use App\Repositories\RoleRepository;
use App\Repositories\SiteCurrencyRepository;
use App\Repositories\StateRepository;
use App\Repositories\UserGroupRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerModelContracts();
    }

    /**
     * Register the Admin Menu instance.
     *
     * @return void
     */
    protected function registerModelContracts()
    {
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(AttributeInterface::class, AttributeRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(ConfigurationInterface::class, ConfigurationRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);

        $this->app->bind(ProductDownloadableUrlInterface::class, ProductDownloadableUrlRepository::class);
        $this->app->bind(OrderHistoryInterface::class, OrderHistoryRepository::class);
        $this->app->bind(PropertyInterface::class, PropertyRepository::class);
        $this->app->bind(CategoryFilterInterface::class, CategoryFilterRepository::class);
        $this->app->bind(AdminUserInterface::class, AdminUserRepository::class);

        $this->app->bind(MenuInterface::class, MenuRepository::class);
        $this->app->bind(PageInterface::class, PageRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(SiteCurrencyInterface::class, SiteCurrencyRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(UserGroupInterface::class, UserGroupRepository::class);
        $this->app->bind(CountryInterface::class, CountryRepository::class);
        $this->app->bind(StateInterface::class, StateRepository::class);
        $this->app->bind(OrderStatusInterface::class, OrderStatusRepository::class);
        $this->app->bind(SiteCurrencyInterface::class, SiteCurrencyRepository::class);
    }
}
