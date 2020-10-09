<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tarifas extends Model
{
    protected $table = 'tarifas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'monto',
        'tipo_vehiculo_id',
    ];
    public $timestamps = false;
/*****************************************/  
    public function tipo_vehiculo()
    {
        return $this->belongsTo('App\Model\TipoVehiculo');
    }
}
