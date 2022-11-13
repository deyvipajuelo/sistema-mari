<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tipopersonal;

class TipopersonalController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $tipopersonales= Tipopersonal::orderBy('id','desc')->paginate(7);
        }else{
            $tipopersonales= Tipopersonal::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(7);
        }
        
        
        return [
            'pagination'=>[
                'total' => $tipopersonales->total(),
                'current_page' => $tipopersonales->currentPage(),
                'per_page' =>$tipopersonales->perPage(),
                'last_page' =>$tipopersonales->lastPage(),
                'from' =>$tipopersonales->firstItem(),
                'to' =>$tipopersonales->lastItem(),
            ],
            'tipopersonales' =>$tipopersonales
        ];
    }
    // funcion para retornar listado con registros activos en formulario hijo
    public function selectTipopersonal(Request $request){
         if(!$request->ajax()) return redirect('/');
         $tipopersonales=Tipopersonal::where('condicion','=','1')
         ->select('id','nombre')->orderBy('nombre','asc')->get();
         return ['tipopersonales'=>$tipopersonales];
     }
   
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tipopersonal=new Tipopersonal();
        $tipopersonal->nombre=$request->nombre;
        $tipopersonal->condicion='1';
        $tipopersonal->save();
    }

    
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tipopersonal= Tipopersonal::findOrFail($request->id);
        $tipopersonal->nombre=$request->nombre;
        $tipopersonal->condicion='1';
        $tipopersonal->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tipopersonal= Tipopersonal::findOrFail($request->id);
        $tipopersonal->condicion='0';
        $tipopersonal->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tipopersonal= Tipopersonal::findOrFail($request->id);
        $tipopersonal->condicion='1';
        $tipopersonal->save();
    }
}
