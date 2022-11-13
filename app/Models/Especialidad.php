<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table='especialidades';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];

    //se crea esa funcion para hacer referencia a la tabla hija
    public function expediente(){
        return $this->hasMany('App\Models\Expediente');
    }
}
