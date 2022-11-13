<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstanciaJudicial extends Model
{
    protected $table='instancia_judiciales';
    protected $primarykey='id';
    protected $fillable=['idojudicial','idljudicial','nombre','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function ojudiciale(){
        return $this->belongsTo('App\Models\OrganoJudicial');
    }
    public function ljudiciale(){
        return $this->belongsTo('App\Models\LocalJudicial');
    }
    //se crea esa funcion para hacer referencia a la tabla hija
    public function ingreso(){
        return $this->hasMany('App\Models\Ingreso');
    }
    public function legajo(){
        return $this->hasMany('App\Models\Legajo');
    }
}
