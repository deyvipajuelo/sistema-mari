<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleProcesal extends Model
{
    protected $table='detalle_procesales';
    protected $primarykey='id';
    protected $fillable=['idpprocesal','idcpersona','apellido','nombre','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function expediente(){
        return $this->belongsTo('App\Models\Expediente');
    }
    public function clasepersona(){
        return $this->belongsTo('App\Models\ClasePersona');
    }
    public function parteprocesal(){
        return $this->belongsTo('App\Models\ParteProcesal');
    }
    //se crea esa funcion para hacer referencia a la tabla hija
}
