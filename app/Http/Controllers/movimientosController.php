<?php

namespace App\Http\Controllers;
use DateTime;
use Illuminate\Http\Request;
use App\Model\Mapa;
use App\Model\Movimientos;
use App\Model\Personas;
use App\Model\Vehiculos;
use App\Model\TipoVehiculo;
use App\Model\TabuladorDescuento;
use App\Model\Tarifas;
use App\Model\Factura;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\App;


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
            'hora_entrada'      => date('h:i a'),
            'status_mov'        => $request->status_mov,
            'vehiculos_id'      => $id_vehiculo,
            'mapa_id'           => $request->puesto_id,                  
        ]);

        $Mapa = mapa::find($request->puesto_id);
            $Mapa->status  = 'O';
            $Mapa->save();
    }

    public function consultarmovimiento(Request $request)
    {
        $Entrada = DB::table('vehiculos')
            ->join('personas', 'personas.id', '=', 'vehiculos.personas_id')
            ->join('tipo_vehiculo', 'tipo_vehiculo.id', '=', 'vehiculos.tipo_vehiculo_id')
            ->join('movimientos', 'movimientos.vehiculos_id', '=', 'vehiculos.id')
            ->where('movimientos.status_mov', '=', 'A')
            ->join('mapa', 'mapa.id', '=', 'movimientos.mapa_id')
            ->where('vehiculos.identificador', '=', $request->identificador)
            ->select('vehiculos.*', 'personas.*', 'tipo_vehiculo.*', 'mapa.*', 'movimientos.*')
            ->get();
            return [response()->json([
                'Success' => true,
                'Entrada' => $Entrada
            ])];            
    }
    public function registrarsalida(Request $request){
        if($request->tipo_vehiculo_id == 1 || $request->tipo_vehiculo_id == 2){
            if($request->fila == 1 || $request->fila == 5){ //si es fila 1 y 5 que son las que pueden ser bloqueadas
                $id_siguiente = $request->mapa_id + 1;
                $PuestoStatus = DB::table('mapa')->where('mapa.id', '=', $id_siguiente)->select('mapa.status', 'mapa.id')->get();
                foreach($PuestoStatus as $e){
                    $PuestoCondicion = $e->status;
                    $siguiente_id = $e->id;
                    }
                if($PuestoCondicion == 'O'){ //Si esta bloquenado la salida
                    $Mapa = mapa::find($siguiente_id);
                    $Mapa->status  = 'D';
                    $Mapa->save();

                    //buscar los movimientos no facturados del id siguinte
                    $Movimiento_Siguiente = DB::table('movimientos')
                        ->where('movimientos.mapa_id', '=', $siguiente_id)
                        ->where('movimientos.status_mov', '=', 'A')
                        ->select('movimientos.*')->get();
                    foreach($Movimiento_Siguiente as $MovSig){
                        $id_mov = $MovSig->id;
                    }
                    //Transfiriendo el puesto que se acaba de desocupar al vehiculo que estaba bloquenado la salida
                    $Movimientos = movimientos::find($id_mov);
                    $Movimientos->mapa_id  = $request->mapa_id;
                    $Movimientos->save();

                    //Asignando la fecha y hora de salida y cerrando el ticket
                    $Movimientos = movimientos::find($request->id);
                    $Movimientos->fecha_salida  = date('Y-m-d');
                    $Movimientos->hora_salida   = date('h:i a');
                    $Movimientos->status_mov    = 'C';
                    $Movimientos->save();
                }else{
                    $Mapa = mapa::find($request->mapa_id);
                    $Mapa->status  = 'D';
                    $Mapa->save();
                    //Asignando la fecha y hora de salida y cerrando el ticket
                    $Movimientos = movimientos::find($request->id);
                    $Movimientos->fecha_salida  = date('Y-m-d');
                    $Movimientos->hora_salida   = date('h:i a');
                    $Movimientos->status_mov    = 'C';
                    $Movimientos->save();                   
                }
            } //fin si es la fila 1 y 5
            else if($request->fila == 2 || $request->fila == 4){
                $Mapa = mapa::find($request->mapa_id);
                $Mapa->status  = 'D';
                $Mapa->save();
                
                $Movimientos = movimientos::find($request->id);
                $Movimientos->fecha_salida  = date('Y-m-d');
                $Movimientos->hora_salida  = date('h:i a');
                $Movimientos->save();
            }//fin si es fila 2 3 4
        }//fin si es moto o automovil
        if($request->fila == 3 && $request->tipo_vehiculo_id == 3){ //Si son Bicicletas
            $Mapa = mapa::find($request->mapa_id);
            $Mapa->status  = 'D';
            $Mapa->save();
            
            $Movimientos = movimientos::find($request->id);
            $Movimientos->fecha_salida  = date('Y-m-d');
            $Movimientos->hora_salida  = date('h:i a');
            $Movimientos->status_mov    = 'C';
            $Movimientos->save();            
        } //fin Si son Bicicletas
        
        //Mandando a Facturar
        $Movimiento = DB::table('movimientos')
        ->where('movimientos.id', '=', $request->id)
        ->select('movimientos.*')->get();

        foreach($Movimiento as $data){
            $fec_entrada = $data->fecha_entrada;
            $hor_entrada = $data->hora_entrada;
            $fec_salida  = $data->fecha_salida;
            $hor_salida  = $data->hora_salida;
        }
   
        $h_entrada = explode(" ", $hor_entrada);
        $h_entrada = $h_entrada[0];

        $h_salida = explode(" ", $hor_salida);
        $h_salida = $h_salida[0];
        $horaInicio = new DateTime($h_entrada);
        $horaTermino = new DateTime($h_salida);
        
        $interval = $horaInicio->diff($horaTermino);
        $total_hora = $interval->format('%h');
        $total_minutos = $interval->format('%i');
        
        $Tarifas = tarifas::all();         
        foreach($Tarifas as $data){
            if($data->tipo_vehiculo_id == $request->tipo_vehiculo_id){
                if($total_hora >= 1){
                    $mto_hora = $total_hora * $data->monto;
                    $costo_minuto = $data->monto / 60;
                    $mto_min = $total_minutos * $costo_minuto;
                    $sub_total = $mto_hora + $mto_min;
                }else{
                    $costo_minuto = $data->monto / 60;
                    $sub_total = $total_minutos * $costo_minuto;
                }
                $Descuentos = TabuladorDescuento::all();
                foreach($Descuentos as $data){
                    if($data->descuento > 0){
                        $horas_a_min = $total_hora * 60;
                        $total_tiempo_minutos = $horas_a_min + $total_minutos;
                        if($total_tiempo_minutos > $data->minutos){
                            $descuento_porcen = $data->descuento / 100;
                            $monto_descuento = $sub_total * $descuento_porcen;
                            $neto_pagar = $sub_total - $monto_descuento;                            
                        }else{
                            $neto_pagar = $sub_total;
                        }                        
                    }
                }//fin foreach descuentos
            }
        }//fin foreach tarifas
        
        //Guardando Factura
        $Factura = factura::find(DB::table('factura')->max('id'));
        if(empty($Factura->id)){
            $numero = '0001';
        }else{
            if($Factura->id < 1000){
                $numero = str_pad($Factura->id, 4, "0", STR_PAD_LEFT);
            }else{
                $numero = $Factura->id;
            }
        }
        $Facturas = factura::create([
            'numero'                  => $numero,
            'fecha'                   => date('Y-m-d'),
            'monto_factura'           => $neto_pagar,
            'tabulador_descuento_id'  => 1,
            'movimientos_id'          => $request->id,
        ]);
    }

    public function imprimirTicketEntrada(Request $request)
    {
        $vehiculo = DB::table('vehiculos')->where('vehiculos.identificador', '=', $request->identificador)->select('vehiculos.*')->get();
        foreach($vehiculo as $data){
            $id_vehiculo = $data->id;
            $placa = $data->identificador;
            $id_persona = $data->personas_id;
        }

        $entrada = DB::table('movimientos')
                          ->where('movimientos.vehiculos_id', '=', $id_vehiculo)
                          ->where('movimientos.status_mov', '=', 'A')
                          ->select('movimientos.fecha_entrada', 'movimientos.hora_entrada', 'movimientos.mapa_id')->get();
        foreach($entrada as $data){
            $id_mapa = $data->mapa_id;
            $fecha_entrada = $data->fecha_entrada;
            $hora_entrada = $data->hora_entrada;
        }
        
        $persona = DB::table('personas')->where('personas.id', '=', $id_persona)->select('personas.nombres', 'personas.apellidos')->get();
        foreach($persona as $data){
            $nombres = $data->nombres;
            $apellidos = $data->apellidos;
        }

        $mapa = DB::table('mapa')->where('mapa.id', '=', $id_mapa)->select('mapa.puesto')->get();
        foreach($mapa as $data){
            $puesto = $data->puesto;
        }
       
        $view = View::make('reportes.ticketentrada', compact('fecha_entrada', 'hora_entrada', 'puesto', 'placa', 'nombres', 'apellidos'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('a4');
        return $pdf->stream('ticketentrada');
    }

    public function imprimirTicketSalida(Request $request){
        $vehiculo = DB::table('vehiculos')->where('vehiculos.identificador', '=', $request->identificador)->select('vehiculos.*')->get();
        foreach($vehiculo as $data){
            $id_vehiculo = $data->id;
            $placa = $data->identificador;
        }

        $entrada = DB::table('movimientos')
        ->where('movimientos.id', '=', $request->id)
        ->select( 'movimientos.*')->get();                          
        foreach($entrada as $data){
            $movi_id = $data->id;
            $id_mapa = $data->mapa_id;
            $fecha_entrada = $data->fecha_entrada;
            $hora_entrada = $data->hora_entrada;
            $fecha_salida = $data->fecha_salida;
            $hora_salida = $data->hora_salida;
        }
        $mapa = DB::table('mapa')->where('mapa.id', '=', $id_mapa)->select('mapa.puesto')->get();
        foreach($mapa as $data){
            $puesto = $data->puesto;
        }
        
        $factura = DB::table('factura')->where('factura.movimientos_id', '=', $movi_id)->select('factura.*')->get();
        foreach($factura as $data){
            $numero_factura = $data->numero;
            $fecha_factura = $data->fecha;
            $monto_factura = $data->monto_factura;
        }
        
        $persona = DB::table('personas')->where('personas.id', '=', $request->id_persona)->select('personas.nombres', 'personas.apellidos')->get();
        foreach($persona as $data){
            $nombres = $data->nombres;
            $apellidos = $data->apellidos;
        }
        $view = View::make('reportes.ticktetsalida', compact('fecha_entrada', 'hora_entrada', 'puesto', 'placa', 'fecha_salida', 'hora_salida', 'numero_factura', 'fecha_factura', 'monto_factura', 'nombres', 'apellidos'))->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($view)->setPaper('a4');
        return $pdf->stream('ticketsalida');
    }

    public function imprimirEntradaSalida(Request $request){
        $facturas = DB::table('factura')           
            ->join('movimientos', 'factura.movimientos_id', '=', 'movimientos.id')
            ->where('factura.fecha', '>=', $request->fecha_desde)
            ->where('factura.fecha', '<=', $request->fecha_hasta)            
            ->select('factura.*', 'movimientos.*')
            ->get();

            $view = View::make('reportes.entradasalida', compact('facturas'))->render();
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('a4');
            return $pdf->stream('movimientos');            
    }

    public function imprimirVehiculosTipo(Request $request){
        $vehiculos = DB::table('vehiculos')           
            ->join('movimientos', 'vehiculos.id', '=', 'movimientos.vehiculos_id')
            ->where('movimientos.fecha_entrada', '>=', $request->fecha_desde)
            ->where('movimientos.fecha_entrada', '<=', $request->fecha_hasta)
            ->where('vehiculos.tipo_vehiculo_id', '=', 1)            
            ->select('vehiculos.id')
            ->get();
            $tipo_1 = count($vehiculos);

            $vehiculos = DB::table('vehiculos')           
            ->join('movimientos', 'vehiculos.id', '=', 'movimientos.vehiculos_id')
            ->where('movimientos.fecha_entrada', '>=', $request->fecha_desde)
            ->where('movimientos.fecha_entrada', '<=', $request->fecha_hasta)
            ->where('vehiculos.tipo_vehiculo_id', '=', 2)            
            ->select('vehiculos.id')
            ->get();
            $tipo_2 = count($vehiculos);

            $vehiculos = DB::table('vehiculos')           
            ->join('movimientos', 'vehiculos.id', '=', 'movimientos.vehiculos_id')
            ->where('movimientos.fecha_entrada', '>=', $request->fecha_desde)
            ->where('movimientos.fecha_entrada', '<=', $request->fecha_hasta)
            ->where('vehiculos.tipo_vehiculo_id', '=', 3)            
            ->select('vehiculos.id')
            ->get();
            $tipo_3 = count($vehiculos);            

            $view = View::make('reportes.vehiculostipo', compact('tipo_1', 'tipo_2', 'tipo_3'))->render();
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('a4');
            return $pdf->stream('vehiculostipo');            
    }

    public function imprimirTotalDiario(Request $request){
        $SQL = "select sum(monto_factura) as total, fecha from factura where fecha BETWEEN '".$request->fecha_desde."' and '".$request->fecha_hasta."' GROUP BY fecha";
        $facturas = DB::select($SQL, array(1,20));
       

            $view = View::make('reportes.montoxdia', compact('facturas'))->render();
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('a4');
            return $pdf->stream('montopordia');            
    }
    
    public function imprimirMasUtilizado(Request $request){
        $SQL = "SELECT count(DISTINCT mapa_id) as veces, puesto FROM movimientos a, mapa b WHERE fecha_entrada BETWEEN '".$request->fecha_desde."' and '".$request->fecha_hasta."' and b.id = a.mapa_id GROUP by puesto ORDER BY veces DESC";
        $puestos = DB::select($SQL, array(1,20));
       

            $view = View::make('reportes.puestoiteraciones', compact('puestos'))->render();
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($view)->setPaper('a4');
            return $pdf->stream('iteraciones');            
    }    
}
