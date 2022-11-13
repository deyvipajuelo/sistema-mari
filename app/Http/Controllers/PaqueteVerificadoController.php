<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaqueteVerificado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaqueteVerificadoController extends Controller
{
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/'); 
        $registro=new PaqueteVerificado();
        $registro->idingreso=$request->idingreso;
        $registro->verificado=1;
        $registro->cantidad=$request->cantidad;
        $registro->idusuario=$request->idusuario;
        $registro->condicion='1';
        $registro->save();
    }
    public function obtenerTotal(Request $request){
        if(!$request->ajax()) return redirect('/');

        $numero=$request->numero;
        $consulta= DB::select('select count(id) as total from paquete_verificados 
        where idingreso='.$numero.' and condicion=1 limit 1');
        return ['consulta' =>$consulta];
    }
    public function obtenerSumaVerificado(Request $request){
        if(!$request->ajax()) return redirect('/');

        $numero=$request->numero;
        $consulta= DB::select('select sum(cantidad) as acumulado from paquete_verificados 
        where idingreso='.$numero.' and condicion=1 limit 1');
        return ['consulta' =>$consulta];
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= PaqueteVerificado::findOrFail($request->idingreso);
        $registro->verificado=1;
        $registro->cantidad=$request->cantidad;
        $registro->condicion='1';
        $registro->save();
    }
}
