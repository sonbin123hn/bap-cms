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



Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/post/{post}', 'PostController@show')->name('post');

Route::middleware('auth')->group(function(){
    Route::get('/admin', 'AdminsController@index')->name('admin.index');
});


