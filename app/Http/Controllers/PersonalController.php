<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personal;

class PersonalController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $personales= Personal::join('tipopersonales','personales.idtipopersonales','=','tipopersonales.id')
            ->select('personales.id','personales.idtipopersonales','personales.nombre','tipopersonales.nombre as nombre_tipo','personales.condicion')
            ->orderBy('personales.id','desc')->paginate(7);
        }else{
            $personales= Personal::join('tipopersonales','personales.idtipopersonales','=','tipopersonales.id')
            ->select('personales.id','personales.idtipopersonales','personales.nombre','tipopersonales.nombre as nombre_tipo','personales.condicion')
            ->where('personales.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('personales.id','desc')->paginate(7);
           
        }
        
        
        return [
            'pagination'=>[
                'total' => $personales->total(),
                'current_page' => $personales->currentPage(),
                'per_page' =>$personales->perPage(),
                'last_page' =>$personales->lastPage(),
                'from' =>$personales->firstItem(),
                'to' =>$personales->lastItem(),
            ],
            'personales' =>$personales
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $personal=new Personal();
        $personal->idtipopersonales=$request->idtipopersonales;
       
        $personal->nombre=$request->nombre;
        
        $personal->condicion='1';
        $personal->save();
    }

    
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $personal= Personal::findOrFail($request->id);
        $personal->idtipopersonales=$request->idtipopersonales;
       
        $personal->nombre=$request->nombre;
       
        $personal->condicion='1';
        $personal->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $personal= Personal::findOrFail($request->id);
        $personal->condicion='0';
        $personal->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $personal= Personal::findOrFail($request->id);
        $personal->condicion='1';
        $personal->save();
    }
    public function selectPersonal(Request $request){
        if(!$request->ajax()) return redirect('/');
        $personales=Personal::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['personales'=>$personales];
    }
    public function comboPersonal(Request $request){
        if(!$request->ajax()) return redirect('/');
        $combopersonal=Personal::where('condicion','=','1')
        ->where('idtipopersonales','=',$request->idtipopersonal)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['combopersonal'=>$combopersonal];
    }
}
