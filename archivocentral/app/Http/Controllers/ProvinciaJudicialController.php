<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProvinciaJudicial;

class ProvinciaJudicialController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $consultas= ProvinciaJudicial::join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
            ->select('provincia_judiciales.id','provincia_judiciales.iddjudicial','provincia_judiciales.nombre','distrito_judiciales.nombre as distrito','provincia_judiciales.condicion')
            ->orderBy('provincia_judiciales.id','desc')->paginate(10);
        }else{
            $consultas= ProvinciaJudicial::join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
            ->select('provincia_judiciales.id','provincia_judiciales.iddjudicial','provincia_judiciales.nombre','distrito_judiciales.nombre as distrito','provincia_judiciales.condicion')
            ->where('provincia_judiciales.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('provincia_judiciales.id','desc')->paginate(10);
           
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
        $registro=new ProvinciaJudicial();
        $registro->iddjudicial=$request->iddjudicial;
        $registro->nombre=$request->nombre;
        $registro->condicion='1';
        $registro->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= ProvinciaJudicial::findOrFail($request->id);
        $registro->iddjudicial=$request->iddjudicial;
        $registro->nombre=$request->nombre;
        $registro->condicion='1';
        $registro->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= ProvinciaJudicial::findOrFail($request->id);
        $registro->condicion='0';
        $registro->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= ProvinciaJudicial::findOrFail($request->id);
        $registro->condicion='1';
        $registro->save();
    }
    public function selectProvinciaJudicial(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consultas=ProvinciaJudicial::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['consultas'=>$consultas];
    }
    public function comboProvinciaJudicial(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consultas=ProvinciaJudicial::where('condicion','=','1')
        ->where('iddjudicial','=',$request->iddjudicial)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['consultas'=>$consultas];
    }
}
