<?php

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
    return view('content/content');
});

//Categories Index
Route::get('/categoria', 'CategoryController@index');
//Register Category
Route::post('/categoria/registrar', 'CategoryController@store');
//Update Category
Route::put('/categoria/actualizar', 'CategoryController@update');
//Deactivate Category
Route::put('/categoria/desactivar', 'CategoryController@deactivate');
//Activate Category
Route::put('/categoria/activar', 'CategoryController@activate');


