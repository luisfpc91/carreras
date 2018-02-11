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

Route::post('/escuderias','EscuderiaController@store');
Route::get('/escuderias','EscuderiaController@index');
Route::put('/escuderias','EscuderiaController@update');
Route::delete('/escuderias','EscuderiaController@destroy');

Route::post('/pilotos','PilotoController@store');
Route::get('/pilotos','PilotoController@index');
Route::put('/pilotos','PilotoController@update');
Route::delete('/pilotos','PilotoController@destroy');

Route::post('/carreras','CarreraController@store');
Route::get('/carreras','CarreraController@index');
Route::put('/carreras','CarreraController@update');
Route::delete('/carreras','CarreraController@destroy');

Route::post('/detalles_carreras','DetalleCarreraController@store');
Route::get('/detalles_carreras','DetalleCarreraController@index');
Route::put('/detalles_carreras','DetalleCarreraController@update');
Route::delete('/detalles_carreras','DetalleCarreraController@destroy');

Route::post('/images','ImagesController@store');
Route::get('/images','ImagesController@index');
Route::put('/images','ImagesController@update');
Route::delete('/images','ImagesController@destroy');