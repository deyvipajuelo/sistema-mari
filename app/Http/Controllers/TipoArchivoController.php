<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoArchivo;

class TipoArchivoController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $consultas= TipoArchivo::orderBy('id','desc')->paginate(10);
        }else{
            $consultas= TipoArchivo::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
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
    public function selectTipoArchivo(Request $request){
         if(!$request->ajax()) return redirect('/');
         $consultas=TipoArchivo::where('condicion','=','1')
         ->select('id','nombre')->orderBy('nombre','asc')->get();
         return ['consultas'=>$consultas];
     }
   
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/'); 
        $registro=new TipoArchivo();
        $registro->nombre=$request->nombre;
       
        $registro->condicion='1';
        $registro->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= TipoArchivo::findOrFail($request->id);
        $registro->nombre=$request->nombre;
        
        $registro->condicion='1';
        $registro->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= TipoArchivo::findOrFail($request->id);
        $registro->condicion='0';
        $registro->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= TipoArchivo::findOrFail($request->id);
        $registro->condicion='1';
        $registro->save();
    }
}
