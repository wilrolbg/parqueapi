<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TabuladorDescuento extends Model
{
    protected $table = 'tabulador_descuento';
    protected $primaryKey = 'id';
    protected $fillable = [
        'descuento',
        'minutos',        
    ];
    public $timestamps = false;
/*****************************************/  
    public function factura()
    {
        return $this->hasMany('App\Model\Factura');
    }
}
