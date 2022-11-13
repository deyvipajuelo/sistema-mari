<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table='areas';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];

    //se crea esa funcion para hacer referencia a la tabla hija
    public function instancias(){
        return $this->hasMany('App\Models\Instancia');
    }
    public function perfilpuesto(){
        return $this->hasMany('App\Models\PerfilPuesto');
    }
}
