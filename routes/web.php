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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/vbdb/login', 'UserController@login');
Route::post('/vbdb/login', 'UserController@authenticateUser');
Route::middleware(['authentication'])->group(function() {
  Route::get('/vbdb/inventory', 'InventoryController@showInventory');
  Route::post('/vbdb/inventory', 'InventoryController@filterInventory');
  Route::get('/vbdb/autocomplete', 'InventoryController@autocomplete');
});
