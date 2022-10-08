<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\LoginController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// note that all routes in this file with prefix admin

Route::group(['namespace'=>'Dashboard', 'middleware'=>'auth:admin'], function (){
     Route::get('/', 'DashboardController@index')->name('admin.dashboard');
});

Route::group(['namespace'=>'Dashboard', 'middleware'=>'guest:admin'], function (){
    Route::get('/login' ,'LoginController@login')->name('admin.login');
    Route::post('/login' ,'LoginController@postLogin')->name('admin.post.login');
});

