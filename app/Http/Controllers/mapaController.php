<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Mapa;
use Illuminate\Support\Facades\DB;

class mapaController extends Controller
{
    public function index(Request $request)
    {
        $Mapa = mapa::all();         
        return $Mapa;
    }

    public function disponibles(Request $request)
    {
        $Puestos_Disponibles = DB::table('mapa')
        ->where('mapa.status', '=', 'D')
        ->where('mapa.tipo_vehiculo_id', '=', $request->id)
        ->select('mapa.id', 'mapa.puesto', 'mapa.fila', 'mapa.status', 'mapa.tipo_vehiculo_id')
        ->get();
            return $Puestos_Disponibles;
    }      
}
