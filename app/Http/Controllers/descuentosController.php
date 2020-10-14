<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\TabuladorDescuento;
use Illuminate\Support\Facades\DB;

class descuentosController extends Controller
{
    public function actualizardescuento(Request $request)
    {
        $Descuento = TabuladorDescuento::find($request->id);
            $Descuento->descuento  = $request->porcentaje;
            $Descuento->minutos  = $request->tiempo;
            $Descuento->save();
    }  
}
