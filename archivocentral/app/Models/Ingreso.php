<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table='ingresos';
    protected $primarykey='id';
    protected $fillable=['idijudicial','idlocal','idusuario','numero_ingreso','fecha_ingreso',
    'cantidad_expediente','expediente_digitado','verificado','anulado','observacion','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function ijudicial(){
        return $this->belongsTo('App\Models\InstanciaJudicial');
    }
    public function local(){
        return $this->belongsTo('App\Models\Local');
    }
    public function usuario(){
        return $this->belongsTo('App\Models\User');
    }
    //se crea esa funcion para hacer referencia a la tabla hija
    public function expediente(){
        return $this->hasMany('App\Models\Expediente');
    }
    public function ubicacionpaquete(){
        return $this->hasMany('App\Models\UbicacionPaquete');
    }
    public function paqueteverificado(){
        return $this->hasMany('App\Models\PaqueteVerificado');
    }
}
