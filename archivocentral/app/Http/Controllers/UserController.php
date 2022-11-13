<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;

        if($buscar==''){
            $usuarios= User::join('personas','users.idpersona','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.idpersona','personas.nombre','personas.apellido',
            'users.usuario','users.password',
            'users.condicion','users.idrol','roles.nombre as rol',
            DB::raw('concat(personas.apellido," ",personas.nombre)  as persona'))
            ->orderBy('users.id','desc')->paginate(7);
        }else{
            $usuarios= User::join('personas','users.idpersona','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.idpersona','personas.nombre','personas.apellido',
            'users.usuario','users.password',
            'users.condicion','users.idrol','roles.nombre as rol',
            DB::raw('concat(personas.apellido," ",personas.nombre)  as persona'))
            ->where('personas.'.$criterio,'like','%'.$buscar.'%')
            ->orderBy('users.id','desc')->paginate(7);
        }
    
        
        return [
            'pagination'=>[
                'total' => $usuarios->total(),
                'current_page' => $usuarios->currentPage(),
                'per_page' =>$usuarios->perPage(),
                'last_page' =>$usuarios->lastPage(),
                'from' =>$usuarios->firstItem(),
                'to' =>$usuarios->lastItem(),
            ],
            'usuarios' =>$usuarios
        ];
    }
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

            $user = new User();
            $user->idpersona=$request->idpersona;
            $user->idrol=$request->idrol;
            $user->usuario=$request->usuario;
            $user->password=bcrypt($request->password);
            $user->condicion='1';
            
            $user->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
            
            // buscar primero el proveedor a modificar
            $user=User::findOrFail($request->id);
            $user->idrol=$request->idrol;
            $user->usuario=$request->usuario;
            $condi=$request->checked;
            if($condi){
                $user-> password=bcrypt($request->password);
                
            }
            $user->condicion='1';
           
            $user->save();      
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user= User::findOrFail($request->id);
        $user->condicion='0';
        $user->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $user= User::findOrFail($request->id);
        $user->condicion='1';
        $user->save();
    }
    public function obtenerPersona(Request $request){
        if(!$request->ajax()) return redirect('/');
        $personas= User::join('personas','users.idpersona','=','personas.id')
        ->join('sedes','personas.idsede','=','sedes.id')
        ->join('instancias','personas.idinstancia','=','instancias.id')
        ->join('areas','instancias.idarea','=','areas.id')
        ->join('personales','personas.idpersonal','=','personales.id')
        ->select('users.id','users.idpersona','personas.dni', DB::raw('concat(personas.apellido," ",personas.nombre)  as persona'),
        'areas.nombre as area','sedes.nombre as sede','instancias.nombre as instancia',
        DB::raw('concat(upper(personales.nombre)," DE ",upper(instancias.nombre)) as cargo'),
        DB::raw('DATE_FORMAT(curdate(), "%Y-%m") as mes'),
        DB::raw('curdate() as fecha'),
        DB::raw('now() as fecha_completa'))
        ->where('users.id','=',Auth::user()->id)
        ->orderBy('users.idpersona','asc')->take(1)->get();
        return ['personas'=>$personas];
    }
    
    public function actualizarPassword(Request $request)
    {
        if(!$request->ajax()) return redirect('/');   
        $user=User::findOrFail($request->id);
        $user-> password=bcrypt($request->password);
        $user->save();      
    }
}
