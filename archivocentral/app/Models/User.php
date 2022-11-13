<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'idpersona',
        'idrol',
        'usuario',
        'password',
        'condicion'
        
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    
    public function rol(){
        return $this->belongsTo('App\Models\Rol');
    }
    public function persona(){
        return $this->belongsTo('App\Models\Persona');
    }
    //se crea esa funcion para hacer referencia a la tabla hija
    public function ingreso(){
        return $this->hasMany('App\Models\Ingreso');
    }
    public function expediente(){
        return $this->hasMany('App\Models\Expediente');
    }
    public function legajo(){
        return $this->hasMany('App\Models\Legajo');
    }
    public function expedientedesarchivado(){
        return $this->hasMany('App\Models\ExpedienteArchivado');
    }
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
