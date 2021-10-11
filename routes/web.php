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
Route::resource('shoppinglist', 'App\Http\Controllers\ShoppinglistController')/*->middleware('auth')*/;
Route::resource('recipe', 'App\Http\Controllers\RecipeController')/*->middleware('auth')*/;
Route::resource('user', 'App\Http\Controllers\UserController')/*->middleware('auth')*/;
Route::resource('product', 'App\Http\Controllers\ProductController');
Route::resource('recipe', 'App\Http\Controllers\RecipeController');
Route::post('/product/ajax-store','App\Http\Controllers\ProductController@ajaxStore')->name('product.ajax-store');

Route::post('/shoppinglist/{shoppinglist_id}/update-order','App\Http\Controllers\ShoppinglistController@updateOrder')->name('shoppinglist.update-order');
/*Route::get('/users', 'App\Http\Controllers\UserController@index')->name('index');*/

Auth::routes();
