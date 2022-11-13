<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table='personales';
    protected $primarykey='id';
    protected $fillable =[
        'idtipopersonales','nombre','condicion'
    ];
    // se crea esa funcion para hacer referencia a la tabla padre
    public function tipopersonal(){
        return $this->belongsTo('App\Models\Tipopersonal');
    }
    public function persona(){
        return $this->hasMany('App\Models\Persona');
    }
}
