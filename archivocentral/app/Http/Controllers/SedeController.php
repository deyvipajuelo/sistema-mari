<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;

class SedeController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $sedes= Sede::orderBy('id','desc')->paginate(7);
        }else{
            $sedes= Sede::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(7);
        }
        
        
        return [
            'pagination'=>[
                'total' => $sedes->total(),
                'current_page' => $sedes->currentPage(),
                'per_page' =>$sedes->perPage(),
                'last_page' =>$sedes->lastPage(),
                'from' =>$sedes->firstItem(),
                'to' =>$sedes->lastItem(),
            ],
            'sedes' =>$sedes
        ];
    }
    // funcion para retornar listado con registros activos en formulario hijo
    public function selectSede(Request $request){
         if(!$request->ajax()) return redirect('/');
         $sedes=Sede::where('condicion','=','1')
         ->select('id','nombre')->orderBy('nombre','asc')->get();
         return ['sedes'=>$sedes];
     }
   
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $sede=new Sede();
        $sede->nombre=$request->nombre;
        $sede->condicion='1';
        $sede->save();
    }

    
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $sede= Sede::findOrFail($request->id);
        $sede->nombre=$request->nombre;
        $sede->condicion='1';
        $sede->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $sede= Sede::findOrFail($request->id);
        $sede->condicion='0';
        $sede->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $sede= Sede::findOrFail($request->id);
        $sede->condicion='1';
        $sede->save();
    }
}
