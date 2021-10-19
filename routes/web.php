<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;

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
Route::get('/shoppinglist/{shoppinglist}/ajax-add','App\Http\Controllers\ShoppinglistController@ajaxAdd')->name('shoppinglist.ajax-add');
Route::post('/shoppinglist/ajax-delete','App\Http\Controllers\ShoppinglistController@ajaxDelete')->name('shoppinglist.ajax-delete');
Route::post('/shoppinglist/ajax-set-public','App\Http\Controllers\ShoppinglistController@ajaxSetPublic')->name('shoppinglist.ajax-set-public');

Route::get('/recipes', 'App\Http\Controllers\ShoppinglistController@recipes')->middleware('admin')->middleware('auth');
//Route::get('/recipes', ['middleware' => 'admin', function(){
//
//}]);


Route::resource('shoppinglist', 'App\Http\Controllers\ShoppinglistController')/*->middleware('auth')*/;
Route::resource('user', 'App\Http\Controllers\UserController')/*->middleware('auth')*/;
Route::resource('product', 'App\Http\Controllers\ProductController');

Route::name('admin.')->middleware('admin')->prefix('admin')->group(function () {

    Route::get('/', 'App\Http\Controllers\Admin\HomeController@index')->name('startseite');
    Route::post('/product/ajax-store','App\Http\Controllers\Admin\ProductController@ajaxStore')->name('product.ajax-store');
    Route::post('/shoppinglist/{shoppinglist}/update-order','App\Http\Controllers\Admin\ShoppinglistController@updateOrder')->name('shoppinglist.update-order');
    Route::post('/shoppinglist/ajax-delete','App\Http\Controllers\Admin\ShoppinglistController@ajaxDelete')->name('shoppinglist.ajax-delete');
    Route::post('/shoppinglist/ajax-set-public','App\Http\Controllers\Admin\ShoppinglistController@ajaxSetPublic')->name('shoppinglist.ajax-set-public');

    Route::resource('shoppinglist', 'App\Http\Controllers\Admin\ShoppinglistController');
    Route::resource('user', 'App\Http\Controllers\Admin\UserController');
    Route::resource('product', 'App\Http\Controllers\Admin\ProductController');
});


Auth::routes();
