<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClasePersona;

class ClasePersonaController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $consultas= ClasePersona::orderBy('id','desc')->paginate(10);
        }else{
            $consultas= ClasePersona::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
        }
        
        
        return [
            'pagination'=>[
                'total' => $consultas->total(),
                'current_page' => $consultas->currentPage(),
                'per_page' =>$consultas->perPage(),
                'last_page' =>$consultas->lastPage(),
                'from' =>$consultas->firstItem(),
                'to' =>$consultas->lastItem(),
            ],
            'consultas' =>$consultas
        ];
    }
    // funcion para retornar listado con registros activos en formulario hijo
    public function selectClasePersona(Request $request){
         if(!$request->ajax()) return redirect('/');
         $consultas=ClasePersona::where('condicion','=','1')
         ->select('id','nombre')->orderBy('nombre','asc')->get();
         return ['consultas'=>$consultas];
     }
     public function obtenerNombre(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $consultas=ClasePersona::where('id','=',$id)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['consultas'=>$consultas];
    }
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/'); 
        $registro=new ClasePersona();
        $registro->nombre=$request->nombre;
       
        $registro->condicion='1';
        $registro->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= ClasePersona::findOrFail($request->id);
        $registro->nombre=$request->nombre;
        
        $registro->condicion='1';
        $registro->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= ClasePersona::findOrFail($request->id);
        $registro->condicion='0';
        $registro->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= ClasePersona::findOrFail($request->id);
        $registro->condicion='1';
        $registro->save();
    }
}
