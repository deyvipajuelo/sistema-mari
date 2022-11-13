<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    protected $table='sedes';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];

    public function persona(){
        return $this->hasMany('App\Models\Persona');
    }
}
