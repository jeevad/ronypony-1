<?php
/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

$baseAdminUrl = config('avored-framework.admin_url');

Route::middleware(['web'])
    ->name('admin.')
    ->namespace('Admin')
    ->group(function () {

        // Route::get('dashboard', 'Auth\DashboardController@index')->name('dashboard');
        Route::get('/', 'Auth\LoginController@loginForm')->name('login');
        Route::get('login', 'Auth\LoginController@loginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login')->name('login.post');

        Route::get('logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset.token');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email.post');

        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.reset.token');
    });



Route::middleware(['web', 'auth'])
// Route::middleware(['web'])
    ->name('admin.')
    ->namespace('Admin')
    ->group(function () {

        // Route::get('', 'DashboardController@index')
        // ->name('dashboard');
        Route::get('dashboard', 'DashboardController@index')
        ->name('dashboard');


        Route::resource('page', 'Cms\PageController');
        Route::resource('user-group', 'Auth\UserGroupController');
        Route::resource('user', 'Auth\UserController');
        Route::resource('attribute', 'Product\AttributeController');
        Route::resource('category', 'Product\CategoryController');
        Route::resource('product', 'Product\ProductController');
        Route::resource('property', 'Product\PropertyController');
        Route::resource('order-status', 'Product\OrderStatusController');
        Route::resource('role', 'RoleController');
        Route::resource('site-currency', 'SiteCurrencyController');
        Route::resource('admin-user', 'AdminUserController');
        Route::resource('country', 'CountryController');
        Route::resource('state', 'StateController');


        Route::post('get-attribute-element', 'Product\AttributeController@getElementHtml')
        ->name('attribute.element');
        Route::post('product-attribute-panel', 'Product\AttributeController@getAttribute')
        ->name('product-attribute.get-attribute');

        Route::post('get-property-element', 'Product\PropertyController@getElementHtml')
        ->name('property.element');


        Route::post('product-image/upload', 'Product\ProductController@uploadImage')
        ->name('product.upload-image');
        Route::post('product-image/delete', 'Product\ProductController@deleteImage')
        ->name('product.delete-image');

        Route::get('product-downloadable-demo/{token}', 'Product\ProductController@downloadDemoToken')
        ->name('product.download.demo.media');
        Route::get('product-downloadable-main/{token}', 'Product\ProductController@downloadMainToken')
        ->name('product.download.main.media');

        Route::post('edit-product-variation', 'Product\ProductController@editVariation')
        ->name('variation.edit');


        Route::get('order', 'Order\OrderController@index')
        ->name('order.index');


        Route::get('order/{order}', 'Order\OrderController@view')
        ->name('order.view');

        Route::get('order/{order}/send-email-invoice', 'Order\OrderController@sendEmailInvoice')
        ->name('order.send-email-invoice');
        Route::get('order/{order}/change-status', 'Order\OrderController@editStatus')
        ->name('order.change-status');
        Route::put('order/{order}/update-status', 'Order\OrderController@updateStatus')
        ->name('order.update-status');

        Route::put('order/{order}/update-track-codes', 'Order\OrderController@updateTrackCode')
        ->name('order.update-track-code');

        Route::get('menu', 'Cms\MenuController@index')->name('menu.index');
        Route::post('menu', 'Cms\MenuController@store')->name('menu.store');

        Route::get('admin-user-detail', 'AdminUserController@detail')
        ->name('admin-user.detail');
        Route::get('admin-user-api-show', 'AdminUserController@apiShow')
        ->name('admin-user.show.api');


        Route::get('configuration', 'ConfigurationController@index')
        ->name('configuration');
        Route::post('configuration', 'ConfigurationController@store')
        ->name('configuration.store');

        Route::get('module', 'ModuleController@index')
        ->name('module.index');
        Route::get('module/create', 'ModuleController@create')
        ->name('module.create');
        Route::post('module', 'ModuleController@store')
        ->name('module.store');

        Route::get('themes', 'ThemeController@index')
        ->name('theme.index');
        Route::get('themes/create', 'ThemeController@create')
        ->name('theme.create');
        Route::post('themes', 'ThemeController@store')
        ->name('theme.store');

        Route::post('active-themes/{name}', 'ThemeController@activated')
        ->name('theme.activated');
        Route::post('deactive-themes/{name}', 'ThemeController@deactivated')
        ->name('theme.deactivated');
        Route::delete('themes/{name}', 'ThemeController@destroy')
        ->name('theme.destroy');

        Route::get('user/{user}/change-password', 'Auth\UserController@changePasswordGet'
        )->name('user.change-password');

        Route::put('user/{user}/change-password', 'Auth\UserController@changePasswordUpdate'
        )->name('user.change-password.update');
    });
