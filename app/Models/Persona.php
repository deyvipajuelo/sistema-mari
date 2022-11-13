<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table='personas';
    protected $primarykey='id';
    protected $fillable =[
        'idsede','idperfil','idpersonal','idinstancia','apellido','nombre','dni','correo','sexo','fecha_ingreso','firma','ruta','condicion'
    ];
    // se crea esa funcion para hacer referencia a la tabla padre
    public function sede(){
        return $this->belongsTo('App\Models\Sede');
    }
    public function perfil(){
        return $this->belongsTo('App\Models\Perfil');
    }
    public function personal(){
        return $this->belongsTo('App\Models\Personal');
    }
    public function instancia(){
        return $this->belongsTo('App\Models\Instancia');
    }
    // para hacer referencia a la tabla hija
    public function user(){
        return $this->hasMany('App\Models\User');
    }
    
    
}
