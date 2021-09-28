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
Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
Route::get('/user/{user}', [App\Http\Controllers\UserController::class, 'show'])->name('user.show')->middleware('auth');
Route::get('/user/{user}/edit', [App\Http\Controllers\UserController::class, 'show'])->name('user.show')->middleware('auth');

Auth::routes();
