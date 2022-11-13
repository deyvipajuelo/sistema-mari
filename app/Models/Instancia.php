<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instancia extends Model
{
    protected $table='instancias';
    protected $primarykey='id';
    protected $fillable =[
        'idarea','nombre','condicion'
    ];
    // se crea esa funcion para hacer referencia a la tabla padre
    public function areas(){
        return $this->belongsTo('App\Models\Area');
    }
    public function persona(){
        return $this->hasMany('App\Models\Persona');
    }
}
