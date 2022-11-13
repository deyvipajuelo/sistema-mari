<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Legajo extends Model
{
    protected $table='legajos';
    protected $primarykey='id';
    protected $fillable=['idijudicial','idusuario',
    'asunto','anaquel','paquete','condicion'];

    //se crea esa funcion para hacer referencia a la tabla padre
    public function ijudicial(){
        return $this->belongsTo('App\Models\InstanciaJudicial');
    }
    
    public function usuario(){
        return $this->belongsTo('App\Models\User');
    }
    //se crea esa funcion para hacer referencia a la tabla hija
    public function detallelegajo(){
        return $this->hasMany('App\Models\DetalleLegajo');
    }
}
