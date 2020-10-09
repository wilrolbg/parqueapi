<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TipoVehiculo extends Model
{
    protected $table = 'tipo_vehiculo';
    protected $primaryKey = 'id';
    protected $fillable = [
        'descripcion',
    ];
    public $timestamps = false;
/*****************************************/  

    public function vehiculos()
    {
        return $this->hasMany('App\Model\Vehiculos');
    }

    public function mapa()
    {
        return $this->hasMany('App\Model\Mapa');
    }
    
    public function tarifas()
    {
        return $this->hasOne('App\Model\Tarifas');
    }     
}
