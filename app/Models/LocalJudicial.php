<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LocalJudicial extends Model
{
    protected $table='local_judiciales';
    protected $primarykey='id';
    protected $fillable=['idpjudicial','nombre','direccion','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function pjudiciale(){
        return $this->belongsTo('App\Models\ProvinciaJudicial');
    }
    //se crea esa funcion para hacer referencia a la tabla hija
    public function ijudicial(){
        return $this->hasMany('App\Models\InstanciaJudicial');
    }
}
