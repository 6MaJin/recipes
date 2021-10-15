<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('startseite');

Route::post('/product/ajax-store','App\Http\Controllers\ProductController@ajaxStore')->name('product.ajax-store');

Route::post('/shoppinglist/{shoppinglist}/update-order','App\Http\Controllers\ShoppinglistController@updateOrder')->name('shoppinglist.update-order');
Route::post('/shoppinglist/ajax-delete','App\Http\Controllers\ShoppinglistController@ajaxDelete')->name('shoppinglist.ajax-delete');
Route::post('/shoppinglist/ajax-set-public','App\Http\Controllers\ShoppinglistController@ajaxSetPublic')->name('shoppinglist.ajax-set-public');

Route::resource('shoppinglist', 'App\Http\Controllers\ShoppinglistController')/*->middleware('auth')*/;
Route::resource('user', 'App\Http\Controllers\UserController')/*->middleware('auth')*/;
Route::resource('product', 'App\Http\Controllers\ProductController');

Auth::routes();
