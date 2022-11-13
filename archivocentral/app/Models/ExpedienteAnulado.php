<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpedienteAnulado extends Model
{
    protected $table='expediente_anulados';
    protected $primarykey='id';
    protected $fillable=['idexpediente','estado','motivo','idusuario','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function expediente(){
        return $this->belongsTo('App\Models\Expediente');
    }
}
