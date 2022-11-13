<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DistritoJudicial;

class DistritoJudicialController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $consultas= DistritoJudicial::orderBy('id','desc')->paginate(10);
        }else{
            $consultas= DistritoJudicial::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
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
    public function selectDistritoJudicial(Request $request){
         if(!$request->ajax()) return redirect('/');
         $consultas=DistritoJudicial::where('condicion','=','1')
         ->select('id','nombre')->orderBy('nombre','asc')->get();
         return ['consultas'=>$consultas];
     }
   
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/'); 
        $registro=new DistritoJudicial();
        $registro->nombre=$request->nombre;
       
        $registro->condicion='1';
        $registro->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= DistritoJudicial::findOrFail($request->id);
        $registro->nombre=$request->nombre;
        
        $registro->condicion='1';
        $registro->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= DistritoJudicial::findOrFail($request->id);
        $registro->condicion='0';
        $registro->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= DistritoJudicial::findOrFail($request->id);
        $registro->condicion='1';
        $registro->save();
    }
}
