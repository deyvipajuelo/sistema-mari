<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    protected $table='expedientes';
    protected $primarykey='id';
    protected $fillable=['idingreso','codigo','responsable','idespecialidad','numero_origen',
    'anio_expediente','numero_expediente','idtexpediente','numero_folio','numero_cuaderno',
    'idestado','idtarchivo','fecha_conclusion','idtconclusion','fecha_recepcion','idlocal',
    'anaquel','paquete','observacion','idusuario','verificado','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function ingreso(){
        return $this->belongsTo('App\Models\Ingreso');
    }
    public function especialidad(){
        return $this->belongsTo('App\Models\Especialidad');
    }
    public function texpediente(){
        return $this->belongsTo('App\Models\TipoExpediente');
    }
    public function estado(){
        return $this->belongsTo('App\Models\Estado');
    }
    public function tarchivo(){
        return $this->belongsTo('App\Models\TipoArchivo');
    }
    public function tconclusion(){
        return $this->belongsTo('App\Models\TipoConclusion');
    }
    public function local(){
        return $this->belongsTo('App\Models\Local');
    }
    public function usuario(){
        return $this->belongsTo('App\Models\User');
    }
    //se crea esa funcion para hacer referencia a la tabla hija
    public function detalleprocesal(){
        return $this->hasMany('App\Models\DetalleProcesal');
    }
    public function detallemateria(){
        return $this->hasMany('App\Models\DetalleMateria');
    }
    public function expedienteanulado(){
        return $this->hasMany('App\Models\ExpedienteAnulado');
    }
    public function expedientedesarchivado(){
        return $this->hasMany('App\Models\ExpedienteArchivado');
    }
}
