<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InstanciaJudicial;

class InstanciaJudicialController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $consultas= InstanciaJudicial::join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
            ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
            ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
            ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
            ->select('instancia_judiciales.id','instancia_judiciales.idojudicial','instancia_judiciales.nombre as instancia',
            'instancia_judiciales.idljudicial','organo_judiciales.nombre as organo','organo_judiciales.idpjudicial','provincia_judiciales.nombre as provincia',
            'provincia_judiciales.iddjudicial','distrito_judiciales.nombre as distrito','instancia_judiciales.condicion')
            ->orderBy('instancia_judiciales.id','desc')->paginate(10);
        }else{
            $consultas= InstanciaJudicial::join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
            ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
            ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
            ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
            ->select('instancia_judiciales.id','instancia_judiciales.idojudicial','instancia_judiciales.nombre as instancia',
            'instancia_judiciales.idljudicial','organo_judiciales.nombre as organo','organo_judiciales.idpjudicial','provincia_judiciales.nombre as provincia',
            'provincia_judiciales.iddjudicial','distrito_judiciales.nombre as distrito','instancia_judiciales.condicion')
            ->where('instancia_judiciales.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('instancia.id','desc')->paginate(10);
           
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
        $registro=new InstanciaJudicial();
        $registro->idojudicial=$request->idojudicial;
        $registro->idljudicial=$request->idljudicial;
        $registro->nombre=$request->nombre;
        $registro->condicion='1';
        $registro->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= InstanciaJudicial::findOrFail($request->id);
        $registro->idojudicial=$request->idojudicial;
        $registro->idljudicial=$request->idljudicial;
        $registro->nombre=$request->nombre;
        $registro->condicion='1';
        $registro->save();
    } 
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= InstanciaJudicial::findOrFail($request->id);
        $registro->condicion='0';
        $registro->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= InstanciaJudicial::findOrFail($request->id);
        $registro->condicion='1';
        $registro->save();
    }
    public function selectInstanciaJudicial(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consultas=InstanciaJudicial::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['consultas'=>$consultas];
    }
    public function comboInstanciaJudicial(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consultas=InstanciaJudicial::where('condicion','=','1')
        ->where('idojudicial','=',$request->idojudicial)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['consultas'=>$consultas];
    }
    public function obtenerProcedencia(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id=$request->instancia;
        $consultas= InstanciaJudicial::join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
            ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
            ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
            ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
            ->select('instancia_judiciales.id','instancia_judiciales.nombre as instancia',
            'organo_judiciales.nombre as organo','provincia_judiciales.nombre as provincia',
            'distrito_judiciales.nombre as distrito',
            'local_judiciales.nombre as local','instancia_judiciales.condicion')
            ->where('instancia_judiciales.id','=',$id)
            ->orderBy('instancia_judiciales.id','desc')->take(1)->get();
            return ['consultas'=>$consultas];
    }
}
