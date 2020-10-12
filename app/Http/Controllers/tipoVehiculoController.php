<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TipoVehiculo;
use Illuminate\Support\Facades\DB;

class tipoVehiculoController extends Controller
{
    public function index(Request $request)
    {
        $tipoVehiculo = TipoVehiculo::all();
            return $tipoVehiculo;
    } 
}
