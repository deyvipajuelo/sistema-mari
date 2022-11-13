<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UbicacionPaquete extends Model
{
    protected $table='ubicacion_paquetes';
    protected $primarykey='id';
    protected $fillable=['idingreso','idlocal',
    'anaquel','paquete','idusuario','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function ingreso(){
        return $this->belongsTo('App\Models\Ingreso');
    }
    public function local(){
        return $this->belongsTo('App\Models\Local');
    }
    public function usuario(){
        return $this->belongsTo('App\Models\User');
    }
}
