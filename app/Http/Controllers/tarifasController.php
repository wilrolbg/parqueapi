<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Tarifas;
use Illuminate\Support\Facades\DB;
class tarifasController extends Controller
{
    public function consultartarifas(Request $request)
    {
        $Tarifas = tarifas::all();         
        return $Tarifas;
    } 

    public function actualizartarifas(Request $request)
    {
        $Tarifas = tarifas::find($request->id);
            $Tarifas->monto  = $request->monto;
            $Tarifas->save();
    }  
}
