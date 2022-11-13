<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instancia;

class InstanciaController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $instancias= Instancia::join('areas','instancias.idarea','=','areas.id')
            ->select('instancias.id','instancias.idarea','instancias.nombre','areas.nombre as nombre_area','instancias.condicion')
            ->orderBy('instancias.id','desc')->paginate(7);
        }else{
            $instancias= Instancia::join('areas','instancias.idarea','=','areas.id')
            ->select('instancias.id','instancias.idarea','instancias.nombre','areas.nombre as nombre_area','instancias.condicion')
            ->where('instancias.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('instancias.id','desc')->paginate(7);
           
        }
        
        
        return [
            'pagination'=>[
                'total' => $instancias->total(),
                'current_page' => $instancias->currentPage(),
                'per_page' =>$instancias->perPage(),
                'last_page' =>$instancias->lastPage(),
                'from' =>$instancias->firstItem(),
                'to' =>$instancias->lastItem(),
            ],
            'instancias' =>$instancias
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $instancia=new Instancia();
        $instancia->idarea=$request->idarea;
       
        $instancia->nombre=$request->nombre;
        
        $instancia->condicion='1';
        $instancia->save();
    }

    
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $instancia= Instancia::findOrFail($request->id);
        $instancia->idarea=$request->idarea;
       
        $instancia->nombre=$request->nombre;
       
        $instancia->condicion='1';
        $instancia->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $instancia= Instancia::findOrFail($request->id);
        $instancia->condicion='0';
        $instancia->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $instancia= Instancia::findOrFail($request->id);
        $instancia->condicion='1';
        $instancia->save();
    }
    public function selectInstancia(Request $request){
        if(!$request->ajax()) return redirect('/');
        $instancias=Instancia::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['instancias'=>$instancias];
    }
    public function comboInstancia(Request $request){
        if(!$request->ajax()) return redirect('/');
        $comboinstancia=Instancia::where('condicion','=','1')
        ->where('idarea','=',$request->idarea)
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['comboinstancia'=>$comboinstancia];
    }
}
