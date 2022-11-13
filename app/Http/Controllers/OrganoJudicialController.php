<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganoJudicial;

class OrganoJudicialController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $consultas= OrganoJudicial::join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
            ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
            ->select('organo_judiciales.id','organo_judiciales.idpjudicial','organo_judiciales.nombre as organo','provincia_judiciales.iddjudicial','provincia_judiciales.nombre as provincia','distrito_judiciales.nombre as distrito','organo_judiciales.condicion')
            ->orderBy('organo_judiciales.id','desc')->paginate(10);
        }else{
            $consultas= OrganoJudicial::join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
            ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
            ->select('organo_judiciales.id','organo_judiciales.idpjudicial','organo_judiciales.nombre as organo','provincia_judiciales.iddjudicial','provincia_judiciales.nombre as provincia','distrito_judiciales.nombre as distrito','organo_judiciales.condicion')
            ->where('organo_judiciales.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('organo.id','desc')->paginate(10);
           
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
        $registro=new OrganoJudicial();
        $registro->idpjudicial=$request->idpjudicial;
        $registro->nombre=$request->nombre;
        $registro->condicion='1';
        $registro->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= OrganoJudicial::findOrFail($request->id);
        $registro->idpjudicial=$request->idpjudicial;
        $registro->nombre=$request->nombre;
        $registro->condicion='1';
        $registro->save();
    } 
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= OrganoJudicial::findOrFail($request->id);
        $registro->condicion='0';
        $registro->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= OrganoJudicial::findOrFail($request->id);
        $registro->condicion='1';
        $registro->save();
    }
    public function selectOrganoJudicial(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consultas=OrganoJudicial::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['consultas'=>$consultas];
    }
    public function comboOrganoJudicial(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consultas=OrganoJudicial::where('condicion','=','1')
        ->where('idpjudicial','=',$request->idpjudicial)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['consultas'=>$consultas];
    }
}
