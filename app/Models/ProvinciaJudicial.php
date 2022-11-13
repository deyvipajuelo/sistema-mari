<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProvinciaJudicial extends Model
{
    protected $table='provincia_judiciales';
    protected $primarykey='id';
    protected $fillable=['iddjudicial','nombre','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function djudiciale(){
        return $this->belongsTo('App\Models\DistritoJudicial');
    }
    //se crea esa funcion para hacer referencia a la tabla hija
    public function ljudicial(){
        return $this->hasMany('App\Models\LocalJudicial');
    }
    
}
