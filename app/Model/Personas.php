<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Personas extends Model
{
    protected $table = 'personas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'documento',
        'nombres',
        'apellidos',
    ];
    public $timestamps = false;
/*****************************************/   
public function vehiculos()
    {
        return $this->hasMany('App\Model\Vehiculos');
    }
}
