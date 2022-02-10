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

Route::get('signup', 'App\Http\Controllers\UsersController@signup')->name('signup');
Route::post('register', 'App\Http\Controllers\UsersController@createUser')->name('create-user');


Route::get('login', 'App\Http\Controllers\UsersController@login');
Route::post('login', 'App\Http\Controllers\UsersController@postLogin')->name('login');
Route::get('logout', 'App\Http\Controllers\UsersController@logout')->name('logout');
Route::get('dashboard', 'App\Http\Controllers\UsersController@dashboard')->name('dashboard');
