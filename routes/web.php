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

Route::name('product.')
    ->group(function () {
        Route::get('/', 'ProductController@index')->name('index');
        Route::get('/product/{id}', 'ProductController@show')->name('show');
    });

Route::name('line_item.')
    ->group(function () {
        Route::post('/line_item/create', 'LineItemController@create')->name('create');
        Route::post('/line_item/delete', 'LineItemController@delete')->name('delete');
    });

    Route::name('cart.')
      ->group(function () {
          Route::get('/cart', 'CartController@index')->name('index');
          Route::get('/cart/checkout', 'CartController@checkout')->name('checkout');
          Route::get('/cart/success', 'CartController@success')->name('success');
      });