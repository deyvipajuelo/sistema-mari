<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoExpediente extends Model
{
    protected $table='tipo_expedientes';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];

    //se crea esa funcion para hacer referencia a la tabla hija
    public function expediente(){
        return $this->hasMany('App\Models\Expediente');
    }
}
