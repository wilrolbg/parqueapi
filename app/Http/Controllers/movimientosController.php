<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Mapa;
use App\Model\Movimientos;
use App\Model\Personas;
use App\Model\Vehiculos;
use Illuminate\Support\Facades\DB;

class movimientosController extends Controller
{
    public function salvar(Request $request)
    {
        if($request->id_persona == 0){
            $Personas = personas::create([
                'documento'    => $request->documento,
                'nombres'      => $request->nombres,
                'apellidos'    => $request->apellidos,           
            ]);
            $persona_id = personas::find(DB::table('personas')->max('id'));
            $id_persona = $persona_id->id;
        }else{
            $Persona = DB::table('personas')->where('personas.id', '=', $request->id_persona)->select('personas.id')->get();
            foreach($Persona as $p){
                $id_persona = $p->id;
                }
        }
            
        $Vehiculo = DB::table('vehiculos')->where('vehiculos.identificador', '=', $request->placaSerial)->select('vehiculos.id')->get();
        foreach($Vehiculo as $v){
			$id_vehiculo_encontrado = $v->id;
			} 
        if(!empty($id_vehiculo_encontrado)){
            $id_vehiculo = $id_vehiculo_encontrado;
        }else{
            $Vehiculos = vehiculos::create([
                'identificador'     => $request->placaSerial,
                'tipo_vehiculo_id'  => $request->tipoVehiculo_id,
                'personas_id'       => $id_persona,           
            ]);
            $vehiculo_id = vehiculos::find(DB::table('vehiculos')->max('id'));
            $id_vehiculo = $vehiculo_id->id;
        }

        $Movimientos = movimientos::create([
            'fecha_entrada'     => date('Y-m-d'),
            'hora_entrada'      => date('h:i:s'),
            'vehiculos_id'      => $id_vehiculo,
            'mapa_id'           => $request->puesto_id,                  
        ]);

        $Mapa = mapa::find($request->puesto_id);
            $Mapa->status  = 'O';
            $Mapa->save();
    }
}
