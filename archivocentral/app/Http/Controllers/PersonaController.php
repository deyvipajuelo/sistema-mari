<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;

class PersonaController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $personas= Persona::join('sedes','personas.idsede','=','sedes.id')
            ->join('perfiles','personas.idperfil','=','perfiles.id')
            ->join('personales','personas.idpersonal','=','personales.id')
            ->join('instancias','personas.idinstancia','=','instancias.id')
            ->join('areas','instancias.idarea','=','areas.id')
            ->join('tipopersonales','personales.idtipopersonales','=','tipopersonales.id')
            ->select('personas.id','personas.idsede','personas.idperfil','personas.idpersonal','personas.idinstancia','personas.dni',
            'instancias.idarea','personales.idtipopersonales','personas.ruta',
            'personas.apellido','personas.nombre','perfiles.nombre as perfil','personales.nombre as personal',
            'instancias.nombre as instancia','areas.nombre as area','personas.correo','personas.sexo','personas.condicion')
            ->orderBy('personas.id','desc')->paginate(7);
        }else{
            $personas= Persona::join('sedes','personas.idsede','=','sedes.id')
            ->join('perfiles','personas.idperfil','=','perfiles.id')
            ->join('personales','personas.idpersonal','=','personales.id')
            ->join('instancias','personas.idinstancia','=','instancias.id')
            ->join('areas','instancias.idarea','=','areas.id')
            ->join('tipopersonales','personales.idtipopersonales','=','tipopersonales.id')
            ->select('personas.id','personas.idsede','personas.idperfil','personas.idpersonal','personas.idinstancia','personas.dni',
            'instancias.idarea','personales.idtipopersonales','personas.ruta',
            'personas.apellido','personas.nombre','perfiles.nombre as perfil','personales.nombre as personal',
            'instancias.nombre as instancia','areas.nombre as area','personas.correo','personas.sexo','personas.condicion')
            ->where('personas.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('personas.id','desc')->paginate(10);
           
        }
        
        return [
            'pagination'=>[
                'total' => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page' =>$personas->perPage(),
                'last_page' =>$personas->lastPage(),
                'from' =>$personas->firstItem(),
                'to' =>$personas->lastItem(),
            ],
            'personas' =>$personas
        ];
    }

    public function store(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
        /*
           $request->validate([
            'ruta'=>'image|max:1024'
        ]);
        */
        $persona=new Persona();
        $persona->idsede=$request->idsede;
        $persona->idperfil=$request->idperfil;
        $persona->idpersonal=$request->idpersonal;
        $persona->idinstancia=$request->idinstancia;
        $persona->apellido=$request->apellido;
        $persona->nombre=$request->nombre;
        $persona->dni=$request->dni;
        $persona->correo=$request->correo;
        $persona->sexo=$request->sexo;
        //$persona->fecha_ingreso='';
        /*
        $file=$request->file('ruta')->store('public/firmas');
        $url=Storage::url($file);
        
        */
        //$persona->firma= '';
        //$persona->ruta= '';
        $persona->condicion='1';
        $persona->save();

    }

    
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        

        $persona= Persona::findOrFail($request->id);
        $persona->idsede=$request->idsede;
        $persona->idperfil=$request->idperfil;
        $persona->idpersonal=$request->idpersonal;
        $persona->idinstancia=$request->idinstancia;
        $persona->apellido=$request->apellido;
        $persona->nombre=$request->nombre;
        $persona->dni=$request->dni;
        $persona->correo=$request->correo;
        $persona->sexo=$request->sexo;
        //$persona->fecha_ingreso='';
/*
        if($request->hasFile('ruta')){
            $request->validate([
                'ruta'=>'image|max:1024'
               
            ]);
            $file=$request->file('ruta')->store('public/firmas');
            $url=Storage::url($file); 
            $persona->ruta='';
        }

       */
        //$persona->ruta='';
        $persona->condicion='1';
        $persona->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $persona= Persona::findOrFail($request->id);
        $persona->condicion='0';
        $persona->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $persona= Persona::findOrFail($request->id);
        $persona->condicion='1';
        $persona->save();
    }
    public function selectPersona(Request $request){
        if(!$request->ajax()) return redirect('/');
        $personas=Persona::where('condicion','=','1')
        ->select('id as idpersona',DB::raw('concat(apellido," ",nombre)  as persona'))->orderBy('apellido','asc')->get();
        return ['personas'=>$personas];
    }
    public function selectPersonaArea(Request $request){
        if(!$request->ajax()) return redirect('/');
        $valor=$request->valor;
        $personas=Persona::join('instancias','personas.idinstancia','=','instancias.id')
        ->join('areas','instancias.idarea','=','areas.id')
        ->select('personas.id as idpersona',DB::raw('concat(personas.apellido," ",personas.nombre)  as persona'),'areas.nombre as area')
        ->where('personas.condicion','=','1')
        ->where('areas.nombre','=',$valor)
        ->orderBy('personas.apellido','asc')->get();
        return ['personas'=>$personas];
    }
    public function selectPersona1(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $personas= Persona::join('sedes','personas.idsede','=','sedes.id')
        ->join('instancias','personas.idinstancia','=','instancias.id')
        ->join('areas','instancias.idarea','=','areas.id')
        ->join('personales','personas.idpersonal','=','personales.id')
        ->select('personas.id as idpersona','personas.dni', DB::raw('concat(personas.apellido," ",personas.nombre)  as persona'),
        'areas.nombre as area','sedes.nombre as sede','personas.fecha_ingreso',
        DB::raw('concat(upper(personales.nombre)," DE ",upper(instancias.nombre)) as cargo'))
        ->where('personas.id','=',$id)
        ->orderBy('personas.id','asc')->take(1)->get();
        return ['personas'=>$personas];
    }
    public function obtenerPersona(Request $request){
        if(!$request->ajax()) return redirect('/');
        $valor=$request->valor;
        $campo=$request->campo;
        $personas= Persona::join('sedes','personas.idsede','=','sedes.id')
        ->join('instancias','personas.idinstancia','=','instancias.id')
        ->join('areas','instancias.idarea','=','areas.id')
        ->join('personales','personas.idpersonal','=','personales.id')
        ->select('personas.id as idpersona','personas.dni', DB::raw('concat(personas.apellido," ",personas.nombre)  as persona'),
        'areas.nombre as area','sedes.nombre as sede','personas.fecha_ingreso',
        DB::raw('concat(upper(personales.nombre)," DE ",upper(instancias.nombre)) as cargo'))
        ->where('personas.'.$campo,'=',$valor)
        ->orderBy('personas.id','asc')->take(1)->get();
        return ['personas'=>$personas];
    }
    
}
