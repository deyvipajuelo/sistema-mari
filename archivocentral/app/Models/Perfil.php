<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    protected $table='perfiles';
    protected $primarykey='id';
    protected $fillable=['nombre','condicion'];

    public function persona(){
        return $this->hasMany('App\Models\Persona');
    }
}
