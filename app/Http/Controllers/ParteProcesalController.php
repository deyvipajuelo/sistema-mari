<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ParteProcesal;

class ParteProcesalController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $consultas= ParteProcesal::orderBy('id','desc')->paginate(10);
        }else{
            $consultas= ParteProcesal::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(10);
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
    public function selectParteProcesal(Request $request){
         if(!$request->ajax()) return redirect('/');
         $consultas=ParteProcesal::where('condicion','=','1')
         ->select('id','nombre')->orderBy('nombre','asc')->get();
         return ['consultas'=>$consultas];
     }
     public function obtenerNombre(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $consultas=ParteProcesal::where('id','=',$id)
        ->select('id','nombre')->orderBy('nombre','asc')->take(1)->get();
        return ['consultas'=>$consultas];
    }
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/'); 
        $registro=new ParteProcesal();
        $registro->nombre=$request->nombre;
       
        $registro->condicion='1';
        $registro->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= ParteProcesal::findOrFail($request->id);
        $registro->nombre=$request->nombre;
        
        $registro->condicion='1';
        $registro->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= ParteProcesal::findOrFail($request->id);
        $registro->condicion='0';
        $registro->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= ParteProcesal::findOrFail($request->id);
        $registro->condicion='1';
        $registro->save();
    }
}
