<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Personas;
use Illuminate\Support\Facades\DB;

class personasController extends Controller
{
    public function buscar(Request $request)
    {
        $Persona = DB::table('personas')
        ->where('personas.documento', '=', $request->documento)
        ->select('personas.id', 'personas.documento', 'personas.nombres', 'personas.apellidos')
        ->get();
         return [response()->json([
                'Success' => true,
                'Persona' => $Persona
            ])];
    } 
}
