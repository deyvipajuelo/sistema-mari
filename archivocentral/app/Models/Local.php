<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table='locales';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];

    //se crea esa funcion para hacer referencia a la tabla hija
    public function ingreso(){
        return $this->hasMany('App\Models\Ingreso');
    }
    public function expediente(){
        return $this->hasMany('App\Models\Expediente');
    }
}
