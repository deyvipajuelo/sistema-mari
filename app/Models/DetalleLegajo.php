<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetalleLegajo extends Model
{
    protected $table='detalle_legajos';
    protected $primarykey='id';
    protected $fillable=['idlegajo','descripcion','observacion','anio','folio','estado','condicion'];
    //se crea esa funcion para hacer referencia a la tabla padre
    public function legajo(){
        return $this->belongsTo('App\Models\Legajo');
    }
    
}
