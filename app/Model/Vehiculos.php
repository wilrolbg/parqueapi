<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vehiculos extends Model
{
    protected $table = 'vehiculos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'identificador',
        'tipo_vehiculo_id',
        'personas_id',
    ];
    public $timestamps = false;
/*****************************************/   
    public function personas()
    {
        return $this->belongsTo('App\Model\Personas');
    }

    public function movimientos()
    {
        return $this->hasMany('App\Model\Movimientos');
    }

    public function tipo_vehiculo()
    {
        return $this->belongsTo('App\Model\TipoVehiculo');
    }    
}
