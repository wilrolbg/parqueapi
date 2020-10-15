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
Route::get('/movimientos/buscar/{identificador}', 'movimientosController@consultarmovimiento');
Route::get('/tarifas/consultar/', 'tarifasController@consultartarifas');
Route::post('/entrada/registrar', 'movimientosController@salvar');
Route::put('/tarifas/actualizar/{id}', 'tarifasController@actualizartarifas');
Route::put('/descuento/actualizar/{id}', 'descuentosController@actualizardescuento');
Route::put('/registrar/salida/{tipo_vehiculo_id}', 'movimientosController@registrarsalida');

//imprimir reportes

Route::get('/imprimir/ticketentrada/{identificador}', 'movimientosController@imprimirTicketEntrada');
Route::post('/imprimir/ticketsalida', 'movimientosController@imprimirTicketSalida');
Route::post('/imprimir/entradasalida', 'movimientosController@imprimirEntradaSalida');
Route::post('/imprimir/vehiculostipo', 'movimientosController@imprimirVehiculosTipo');
Route::post('/imprimir/totaldiario', 'movimientosController@imprimirTotalDiario');
Route::post('/imprimir/masutilizado', 'movimientosController@imprimirMasUtilizado');