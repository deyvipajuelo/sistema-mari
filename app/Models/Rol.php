<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
    protected $primarykey='id';
    protected $fillable = ['nombre','descripcion','condicion'];
    
    public function users(){
        return $this->hasMany('App\Models\User');
    }
}
