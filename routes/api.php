<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')->group(function () {
    // Below mention routes are public, user can access those without any restriction.
    // Create New User
    Route::post('register', 'AuthController@register');
    // Login User
    Route::post('login', 'AuthController@login')->name('login');
    // Refresh the JWT Token
    Route::get('refresh', 'AuthController@refresh');
    // Below mention routes are available only for the authenticated users.
    Route::middleware('auth:api')->group(function () {
        // Get user info
        Route::get('user', 'AuthController@user');
        // Logout user from application
        Route::post('logout', 'AuthController@logout');
    });
});

Route::resource('data', 'DataController');

Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/users', 'UserController@index');
    Route::post('/user', 'UserController@user');
    Route::post('/user/{id}', 'PeminjamanController@chartDataUser');

    Route::resource('peminjaman', 'PeminjamanController');

    Route::post('/dashboard/pinjam', 'PeminjamanController@dashboard');
    Route::post('/dashboard/chartData', 'PeminjamanController@chartData');
    Route::post('/dashboard/pinjam_user', 'PeminjamanController@dashboard_user');

    Route::post('/kembalikanBuku', 'PeminjamanController@kembalikanBuku');
    Route::post('/pengembalian/download', 'PeminjamanController@download');
});
