<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table='materias';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];
    //se crea esa funcion para hacer referencia a la tabla hija
    public function detallemateria(){
        return $this->hasMany('App\Models\DetalleMateria');
    }
}
