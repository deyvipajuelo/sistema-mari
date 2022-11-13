<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $areas= Area::orderBy('id','desc')->paginate(7);
        }else{
            $areas= Area::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(7);
        }
        
        
        return [
            'pagination'=>[
                'total' => $areas->total(),
                'current_page' => $areas->currentPage(),
                'per_page' =>$areas->perPage(),
                'last_page' =>$areas->lastPage(),
                'from' =>$areas->firstItem(),
                'to' =>$areas->lastItem(),
            ],
            'areas' =>$areas
        ];
    }
    // funcion para retornar listado con registros activos en formulario hijo
    public function selectArea(Request $request){
         if(!$request->ajax()) return redirect('/');
         $areas=Area::where('condicion','=','1')
         ->select('id','nombre')->orderBy('nombre','asc')->get();
         return ['areas'=>$areas];
     }
   
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/'); 
        $area=new Area();
        $area->nombre=$request->nombre;
       
        $area->condicion='1';
        $area->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $area= Area::findOrFail($request->id);
        $area->nombre=$request->nombre;
        
        $area->condicion='1';
        $area->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $area= Area::findOrFail($request->id);
        $area->condicion='0';
        $area->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $area= Area::findOrFail($request->id);
        $area->condicion='1';
        $area->save();
    }
}
