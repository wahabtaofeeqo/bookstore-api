<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    Route::post('login', 'LoginController@authenticate');
    Route::post('register', 'RegisterController@store');
});

//
Route::get('books', 'BookController@index');
Route::get('books/{id}', 'BookController@show');

/**
 * Protected Routes
 */
Route::middleware(['auth:sanctum', 'ability:author'])->group(function () {
    Route::post('books', 'BookController@store');
    Route::patch('books/{id}', 'BookController@update');
    Route::delete('books/{id}', 'BookController@destroy');
});
