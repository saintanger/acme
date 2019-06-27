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

Route::get('/', 'Acme\FrontendController@shopIndex')->name('shop_index');
Route::get('/add/{product_id}', 'Acme\CartController@addToCart')->name('add_to_cart');
Route::post('/add-code', 'Acme\CartController@addByCode')->name('add_by_code');
Route::get('/remove/{product_id}', 'Acme\CartController@removeFromCart')->name('remove_from_cart');

