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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('persona', 'PersonaController');
Route::apiResource('vuelo', 'VueloController');
Route::get('persona/searchBy/nombres','PersonaController@SearchNombres');
Route::get('persona/searchBy/email','PersonaController@SearchEmail');
Route::get('persona/searchBy/created','PersonaController@SearchCreated');
Route::get('vuelo/listar', 'VueloController@show');

