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

// Route::get('/', function () {
//     return view('pages.auth.login');
// });
Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@login');
Route::post('/logout', 'App\Http\Controllers\LoginController@logout')->name('logout');

Route::put('/setSetting', 'App\Http\Controllers\DashboardController@setSetting');

Route::prefix('/')->middleware('auth')->group(function() {
    Route::get('/', 'App\Http\Controllers\DashboardController@index');
    Route::get('/realtime_update_status', 'App\Http\Controllers\DashboardController@realtime_update_status');

});

Route::prefix('/user')->middleware('auth')->group(function() {
    Route::get('/', 'App\Http\Controllers\UserController@index');
    Route::post('/store', 'App\Http\Controllers\UserController@store');
    Route::get('/edit/{id}', 'App\Http\Controllers\UserController@edit');
    Route::put('/update/{id}','App\Http\Controllers\UserController@update');
    Route::delete('/destroy/{id}', 'App\Http\Controllers\UserController@destroy');
});

Route::prefix('/toko')->middleware('auth')->group(function() {
    Route::get('/', 'App\Http\Controllers\TokoController@index');
    Route::post('/store', 'App\Http\Controllers\TokoController@store');
    Route::get('/edit/{id}', 'App\Http\Controllers\TokoController@edit');
    Route::put('/update/{id}', 'App\Http\Controllers\TokoController@update');
    Route::delete('/destroy/{id}', 'App\Http\Controllers\TokoController@destroy');
});

Route::prefix('/produk')->middleware('auth')->group(function() {
    Route::get('/', 'App\Http\Controllers\ProdukController@index');
    Route::post('/store', 'App\Http\Controllers\ProdukController@store');
    Route::get('/edit/{id}', 'App\Http\Controllers\ProdukController@edit');
    Route::put('/update/{id}', 'App\Http\Controllers\ProdukController@update');
    Route::delete('/destroy/{id}', 'App\Http\Controllers\ProdukController@destroy');
});

Route::prefix('/retur')->middleware('auth')->group(function() {
    Route::get('/', 'App\Http\Controllers\ItemReturController@index');
    Route::post('/store', 'App\Http\Controllers\ItemReturController@store');
    Route::get('/find/{id}', 'App\Http\Controllers\ItemReturController@find');
    Route::put('/update_status/{id}', 'App\Http\Controllers\ItemReturController@update_status');
});
