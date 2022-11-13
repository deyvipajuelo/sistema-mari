<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaqueteVerificado extends Model
{
    protected $table='paquete_verificados';
    protected $primarykey='id';
    protected $fillable=['idingreso','verificado','cantidad','idusuario','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function ingreso(){
        return $this->belongsTo('App\Models\Ingreso');
    }
    
    public function usuario(){
        return $this->belongsTo('App\Models\User');
    }
}
