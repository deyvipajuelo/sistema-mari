<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipopersonal extends Model
{
    protected $table='tipopersonales';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];

    //se crea esa funcion para hacer referencia a la tabla hija
    public function personales(){
        return $this->hasMany('App\Models\Personal');
    }
}

