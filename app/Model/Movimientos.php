<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    protected $table = 'movimientos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'fecha_entrada',
        'hora_entrada',
        'fecha_salida',
        'hora_salida',
        'vehiculos_id',
        'mapa_id',
    ];
    public $timestamps = false;
/*****************************************/  
    public function mapa()
    {
        return $this->belongsTo('App\Model\Mapa');
    }

    public function vehiculos()
    {
        return $this->belongsTo('App\Model\Vehiculos');
    }
    public function factura()
    {
        return $this->hasMany('App\Model\Factura');
    } 
}
