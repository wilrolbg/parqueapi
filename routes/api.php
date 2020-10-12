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
Route::get('/mapa/cargar', 'mapaController@index');
Route::get('/tipovehiculo/cargar', 'tipoVehiculoController@index');
Route::get('/disponibles/cargar/{id}', 'mapaController@disponibles');
Route::get('/personas/buscar/{documento}', 'personasController@buscar');
Route::post('/entrada/registrar', 'movimientosController@salvar');