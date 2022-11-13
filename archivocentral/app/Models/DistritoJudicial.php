<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DistritoJudicial extends Model
{
    protected $table='distrito_judiciales';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];

    //se crea esa funcion para hacer referencia a la tabla hija
    public function pjudicial(){
        return $this->hasMany('App\Models\ProvinciaJudicial');
    }
    
}
