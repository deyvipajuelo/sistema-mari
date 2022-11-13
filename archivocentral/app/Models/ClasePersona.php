<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasePersona extends Model
{
    protected $table='clase_personas';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];

    //se crea esa funcion para hacer referencia a la tabla hija
    public function detalleprocesal(){
        return $this->hasMany('App\Models\DetalleProcesal');
    }
}
