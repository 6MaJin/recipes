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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('startseite');
Route::resource('shoppinglist', 'App\Http\Controllers\ShoppinglistController')/*->middleware('auth')*/;
Route::resource('user', 'App\Http\Controllers\UserController')/*->middleware('auth')*/;
Route::resource('product', 'App\Http\Controllers\ProductController');
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::get('/user/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show');

Route::get('/menu','App\Http\Controllers\MenuController@index');
Route::post('/menu/update-order','App\Http\Controllers\MenuController@updateOrder');

Route::get('/test', function() {
    return view('test');
});

Auth::routes();
