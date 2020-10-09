<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'factura';
    protected $primaryKey = 'id';
    protected $fillable = [
        'numero',
        'fecha',
        'monto_factura',
        'tabulador_descuento_id',
        'movimientos_id',
    ];
    public $timestamps = false;
/*****************************************/  
    public function movimientos()
    {
        return $this->belongsTo('App\Model\Movimientos');
    }

    public function tabulador_descuento()
    {
        return $this->belongsTo('App\Model\TabuladorDescuento');
    }
}
