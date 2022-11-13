<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $table='estados';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];

    //se crea esa funcion para hacer referencia a la tabla hija
    public function expediente(){
        return $this->hasMany('App\Models\Expediente');
    }
    public function expedientedesarchivado(){
        return $this->hasMany('App\Models\ExpedienteArchivado');
    }
}
