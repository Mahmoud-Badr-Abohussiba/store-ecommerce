<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AuthController;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// note that all routes in this file with prefix admin

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
    Route::group(['prefix' => 'admin', 'namespace' => 'Dashboard', 'middleware' => 'auth:admin'], function () {
        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
        Route::get('logout', 'AuthController@logout')->name('admin.logout');

        // Edit Admin Profile
        Route::group(['prefix' => 'profile'], function () {
            Route::get('edit', 'ProfileController@editProfile')->name('edit.profile');
            Route::put('update', 'ProfileController@updateProfile')->name('update.profile');
            // End Edit Admin Profile
        });

        // Shipping Methods
        Route::group(['prefix' => 'setting'], function () {
            Route::get('shipping-methods/{type}', 'SettingController@editShippingMethod')->name('edit.shipping.method');
            Route::put('shipping-methods/{id}', 'SettingController@updateShippingMethod')->name('update.shipping.method');
            // End Shipping Methods

            // Categories
            Route::group(['prefix' => 'categories'], function () {
                Route::get('index/{type?}', 'CategoryController@index')->name('admin.categories');
                Route::get('create', 'CategoryController@create')->name('admin.categories.create');
                Route::post('store', 'CategoryController@store')->name('admin.categories.store');
                Route::get('edit/{slug}', 'CategoryController@edit')->name('admin.categories.edit');
                Route::put('update/{slug}', 'CategoryController@update')->name('admin.categories.update');
                Route::get('delete/{slug}', 'CategoryController@destroy')->name('admin.categories.delete');
            });
            // End Categories

            // Brands
            Route::group(['prefix' => 'brands'], function () {
                Route::get('/', 'BrandController@index')->name('admin.brands');
                Route::get('create', 'BrandController@create')->name('admin.brands.create');
                Route::post('store', 'BrandController@store')->name('admin.brands.store');
                Route::get('edit/{id}', 'BrandController@edit')->name('admin.brands.edit');
                Route::put('update/{id}', 'BrandController@update')->name('admin.brands.update');
                Route::get('delete/{id}', 'BrandController@destroy')->name('admin.brands.delete');
            });
            // End Brands

            // Products
            Route::group(['prefix' => 'products'], function () {
                Route::get('/', 'ProductController@index')->name('admin.products');
                Route::get('create-general', 'ProductController@create')->name('admin.products.create.general');
                Route::post('store-general-information', 'ProductController@store')->name('admin.products.store.general');

                Route::get('price/{id}', 'ProductController@getPrice')->name('admin.products.price');
                Route::post('price', 'ProductController@saveProductPrice')->name('admin.products.price.store');

                Route::get('stock/{id}', 'ProductController@getStock')->name('admin.products.stock');
                Route::post('stock', 'ProductController@saveProductStock')->name('admin.products.stock.store');

                Route::get('images/{id}', 'ProductController@addImages')->name('admin.products.images');
                Route::post('images', 'ProductController@saveProductImages')->name('admin.products.images.store');
                Route::post('images/db', 'ProductController@saveProductImagesDB')->name('admin.products.images.store.db');
                ############################ product attributes & attributes options ############################################
                Route::group(['prefix'=>'attributes'],function(){
                   Route::get('/', 'AttributeController@index')->name('admin.product.attributes');
                   Route::get('create', 'AttributeController@create')->name('admin.product.attributes.create');
                   Route::post('store', 'AttributeController@store')->name('admin.product.attributes.store');
                   Route::get('edit/{id}', 'AttributeController@edit')->name('admin.product.attributes.edit');
                   Route::put('update/{id}', 'AttributeController@update')->name('admin.product.attributes.update');
                   Route::get('delete/{id}', 'AttributeController@destroy')->name('admin.product.attributes.delete');

                    ############################ attributes options ############################################
                    Route::group(['prefix'=>'options'],function() {
                        Route::get('/', 'OptionController@index')->name('options.index');
                        Route::get('create', 'OptionController@create')->name('options.create');
                        Route::post('store', 'OptionController@store')->name('options.store');
                        Route::get('edit/{id}', 'OptionController@edit')->name('options.edit');
                        Route::put('update/{id}', 'OptionController@update')->name('options.update');
                        Route::get('delete/{id}', 'OptionController@destroy')->name('options.delete');
                    });
                });
            });
            // End Products

            // tags
            Route::group(['prefix' => 'tags'], function () {
                Route::get('/', 'TagController@index')->name('admin.tags');
                Route::get('create', 'TagController@create')->name('admin.tags.create');
                Route::post('store', 'TagController@store')->name('admin.tags.store');
                Route::get('edit/{slug}', 'TagController@edit')->name('admin.tags.edit');
                Route::put('update/{slug}', 'TagController@update')->name('admin.tags.update');
                Route::get('delete/{slug}', 'TagController@destroy')->name('admin.tags.delete');
            });
            // End tags
        });
    });

    Route::group(['prefix' => 'admin', 'namespace' => 'Dashboard', 'middleware' => 'guest:admin'], function () {
        Route::get('/login', 'AuthController@login')->name('admin.login');
        Route::post('/login', 'AuthController@postLogin')->name('admin.post.login');
    });

});


