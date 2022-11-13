<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perfil;

class PerfilController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $perfiles= Perfil::orderBy('id','desc')->paginate(7);
        }else{
            $perfiles= Perfil::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(7);
        }
        
        
        return [
            'pagination'=>[
                'total' => $perfiles->total(),
                'current_page' => $perfiles->currentPage(),
                'per_page' =>$perfiles->perPage(),
                'last_page' =>$perfiles->lastPage(),
                'from' =>$perfiles->firstItem(),
                'to' =>$perfiles->lastItem(),
            ],
            'perfiles' =>$perfiles
        ];
    }
    // funcion para retornar listado con registros activos en formulario hijo
    public function selectPerfil(Request $request){
         if(!$request->ajax()) return redirect('/');
         $perfiles=Perfil::where('condicion','=','1')
         ->select('id','nombre')->orderBy('nombre','asc')->get();
         return ['perfiles'=>$perfiles];
     }
   
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $perfil=new Perfil();
        $perfil->nombre=$request->nombre;
        $perfil->condicion='1';
        $perfil->save();
    }

    
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $perfil= Perfil::findOrFail($request->id);
        $perfil->nombre=$request->nombre;
        $perfil->condicion='1';
        $perfil->save();
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $perfil= Perfil::findOrFail($request->id);
        $perfil->condicion='0';
        $perfil->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $perfil= Perfil::findOrFail($request->id);
        $perfil->condicion='1';
        $perfil->save();
    }
}
