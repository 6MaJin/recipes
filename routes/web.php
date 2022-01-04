<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;

Route::get('/test', 'App\Http\Controllers\ShoppinglistController@test');
Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('startseite');
Route::resource('shoppinglist', 'App\Http\Controllers\ShoppinglistController')->middleware('auth');
Route::post('/shoppinglist/ajax-delete-shoppinglist','App\Http\Controllers\ShoppinglistController@ajaxDeleteShoppinglist')->name('shoppinglist.ajax-delete-shoppinglist');
Route::get('/', 'App\Http\Controllers\HomeController@index' )->name('startseite');
Route::post('/product/ajax-store-product','App\Http\Controllers\ProductController@ajaxStoreProduct')->name('product.ajax-store-product');
Route::post('/shoppinglist/{shoppinglist}/update-order','App\Http\Controllers\ShoppinglistController@updateOrder')->name('shoppinglist.update-order');
Route::get('/shoppinglist/{shoppinglist}/ajax-add-recipe','App\Http\Controllers\ShoppinglistController@ajaxAddRecipe')->name('shoppinglist.ajax-add-recipe');
Route::post('/shoppinglist/ajax-delete-product','App\Http\Controllers\ShoppinglistController@ajaxDeleteProduct')->name('shoppinglist.ajax-delete-product');
Route::post('/shoppinglist/ajax-set-public','App\Http\Controllers\ShoppinglistController@ajaxSetPublic')->name('shoppinglist.ajax-set-public');

Route::get('/recipes', 'App\Http\Controllers\ShoppinglistController@recipes');
Route::resource('user', 'App\Http\Controllers\UserController')->middleware('admin');
Route::resource('product', 'App\Http\Controllers\ProductController');

Route::name('admin.')->prefix('admin')->middleware('admin')->group(function () {

    Route::get('/', 'App\Http\Controllers\Admin\HomeController@index')->name('startseite');
    Route::post('/product/ajax-store','App\Http\Controllers\Admin\ProductController@ajaxStore')->name('product.ajax-store');
    Route::post('/shoppinglist/{shoppinglist}/update-order','App\Http\Controllers\Admin\ShoppinglistController@updateOrder')->name('shoppinglist.update-order');
    Route::post('/shoppinglist/ajax-delete','App\Http\Controllers\Admin\ShoppinglistController@ajaxDelete')->name('shoppinglist.ajax-delete');
    Route::post('/shoppinglist/ajax-set-public','App\Http\Controllers\Admin\ShoppinglistController@ajaxSetPublic')->name('shoppinglist.ajax-set-public');
    Route::post('/user/ajax-set-admin','App\Http\Controllers\Admin\UserController@ajaxSetAdmin')->name('user.ajax-set-admin');
    Route::get('/recipes', 'App\Http\Controllers\Admin\ShoppinglistController@recipes')->middleware('auth');

    Route::resource('shoppinglist', 'App\Http\Controllers\Admin\ShoppinglistController');
    Route::resource('user', 'App\Http\Controllers\Admin\UserController');
    Route::resource('product', 'App\Http\Controllers\Admin\ProductController');
});


Auth::routes();
