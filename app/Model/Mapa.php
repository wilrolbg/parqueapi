<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Mapa extends Model
{
    protected $table = 'mapa';
    protected $primaryKey = 'id';
    protected $fillable = [
        'puesto',
        'fila',
        'status',
        'tipo_vehiculo_id',
    ];
    public $timestamps = false;
/*****************************************/  
    public function tipo_vehiculo()
    {
        return $this->belongsTo('App\Model\TipoVehiculo');
    }

    public function movimientos()
    {
        return $this->hasMany('App\Model\Movimientos');
    }    
}
