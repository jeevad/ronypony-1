<?php

namespace Jcart\Framework\Payment;

use Illuminate\Support\ServiceProvider;
use Jcart\Framework\Payment\Facade as PaymentFacade;
use Jcart\Framework\Payment\Stripe\Payment as StripePayment;

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
    public function boot()
    {
        $this->registerPaymentOptions();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPayment();

        $this->app->alias('payment', 'Jcart\Framework\Payment\Manager');
    }

    /**
     * Register the AdmainConfiguration instance.
     *
     * @return void
     */
    protected function registerPayment()
    {
        $this->app->singleton('payment', function ($app) {
            return new Manager();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['payment', 'Jcart\Framework\Payment\Manager'];
    }


    /**
     * Registering Payment Option for the App.
     *
     *
     * @return void
     */
    protected function registerPaymentOptions()
    {
        $stripe = new StripePayment();
        PaymentFacade::put($stripe->identifier(), $stripe);
    }
}
