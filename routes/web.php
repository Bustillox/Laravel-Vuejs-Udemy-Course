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
// Categories
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
    //Categories Select
    Route::get('/categoria/selectCategoria', 'CategoryController@selectCategory');
//

// Items
    //Categories Index
    Route::get('/articulo', 'ItemController@index');
    //Register Category
    Route::post('/articulo/registrar', 'ItemController@store');
    //Update Category
    Route::put('/articulo/actualizar', 'ItemController@update');
    //Deactivate Category
    Route::put('/articulo/desactivar', 'ItemController@deactivate');
    //Activate Category
    Route::put('/articulo/activar', 'ItemController@activate');
//

// Customers
    //Categories Index
    Route::get('/cliente', 'CustomerController@index');
    //Register Category
    Route::post('/cliente/registrar', 'CustomerController@store');
    //Update Category
    Route::put('/cliente/actualizar', 'CustomerController@update');
//

