<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'Api\AuthController@register');

Route::post('/login', 'Api\AuthController@login');
Route::post('/logout', 'Api\AuthController@logout')->middleware('auth:sanctum');

Route::get('/getlogin', 'Api\AuthController@getdata')->middleware('auth:sanctum');

Route::get('/review', 'Api\ReviewController@index')->middleware('auth:sanctum');
// Route::apiResource('/review', 'Api\ReviewController')->middleware('auth:sanctum', ['only' => ['store']]);
Route::post('/review/{id}', 'Api\ReviewController@store');