<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LocalJudicial;


class LocalJudicialController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $consultas= LocalJudicial::join('provincia_judiciales','local_judiciales.idpjudicial','=','provincia_judiciales.id')
            ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
            ->select('local_judiciales.id','local_judiciales.idpjudicial','local_judiciales.nombre as local','provincia_judiciales.iddjudicial','provincia_judiciales.nombre as provincia','distrito_judiciales.nombre as distrito','local_judiciales.condicion')
            ->orderBy('local_judiciales.id','desc')->paginate(10);
        }else{
            $consultas= LocalJudicial::join('provincia_judiciales','local_judiciales.idpjudicial','=','provincia_judiciales.id')
            ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
            ->select('local_judiciales.id','local_judiciales.idpjudicial','local_judiciales.nombre as local','provincia_judiciales.iddjudicial','provincia_judiciales.nombre as provincia','distrito_judiciales.nombre as distrito','local_judiciales.condicion')
            ->where('local_judiciales.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('local.id','desc')->paginate(10);
           
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
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro=new LocalJudicial();
        $registro->idpjudicial=$request->idpjudicial;
        $registro->nombre=$request->nombre;
        $registro->direccion=$request->direccion;
        $registro->condicion='1';
        $registro->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= LocalJudicial::findOrFail($request->id);
        $registro->idpjudicial=$request->idpjudicial;
        $registro->nombre=$request->nombre;
        $registro->direccion=$request->direccion;
        $registro->condicion='1';
        $registro->save();
    } 
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= LocalJudicial::findOrFail($request->id);
        $registro->condicion='0';
        $registro->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= LocalJudicial::findOrFail($request->id);
        $registro->condicion='1';
        $registro->save();
    }
    public function selectLocalJudicial(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consultas=LocalJudicial::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['consultas'=>$consultas];
    }
    public function comboLocalJudicial(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consultas=LocalJudicial::where('condicion','=','1')
        ->where('idpjudicial','=',$request->idpjudicial)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['consultas'=>$consultas];
    }
}
