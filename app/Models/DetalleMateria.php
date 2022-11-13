<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleMateria extends Model
{
    protected $table='detalle_materias';
    protected $primarykey='id';
    protected $fillable=['idexpediente','idmateria','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function expediente(){
        return $this->belongsTo('App\Models\Expediente');
    }
    public function materia(){
        return $this->belongsTo('App\Models\Materia');
    }
    //se crea esa funcion para hacer referencia a la tabla hija
    
}
