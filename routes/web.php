<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



Route::group(['middleware' => ['auth', 'admin']], function () {
// ADMIN ROUTES

	Route::get('products', 'ProductsController@index');
	Route::post('add-products', 'ProductsController@store');
	Route::get('view-products/{id}', 'ProductsController@show');
	Route::get('edit-product', 'ProductsController@edit');
	Route::post('update-product', 'ProductsController@update');
	Route::post('delete', 'ProductsController@destroy');

});


Route::group(['middleware' => ['auth', 'user']], function(){

// USER ROUTES

	Route::get('dashboard', 'CartsController@index');
	Route::get('show-product', 'CartsController@show');
	Route::post('add-to-cart', 'CartsController@addtocart');
	Route::get('view-cart', 'CartsController@showCart');
	Route::post('checkout', 'CartsController@checkOut');
	Route::post('remove', 'CartsController@destroy');

});