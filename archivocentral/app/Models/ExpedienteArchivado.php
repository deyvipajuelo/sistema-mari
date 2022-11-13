<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpedienteArchivado extends Model
{
    protected $table='expediente_desarchivados';
    protected $primarykey='id';
    protected $fillable=['idexpediente','motivo','idestado','idusuario','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function expediente(){
        return $this->belongsTo('App\Models\Expediente');
    }
}
