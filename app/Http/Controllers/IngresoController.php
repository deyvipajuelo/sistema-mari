<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class IngresoController extends Controller
{
    public function index(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;
        $anio=$request->anio;
        $instancia=$request->instancia;
        $date = Carbon::now();
        $consulta=DB::select('SELECT u.idpersona,upper(r.nombre) as rol1 from personas p,users u,roles r
        where p.id=u.idpersona and r.id=u.idrol and 
        u.id='.Auth::user()->id);
        $idpersona='';
        $rolp='';
        foreach($consulta as $c){
            $idpersona=$c->idpersona;
            $rolp=$c->rol1;
        }
        if($anio==''){
            $anio=$date->format('Y');
        }
        if($rolp=='ADMINISTRADOR DEL SISTEMA'){
            if($buscar==''){
                $consultas= Ingreso::join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
                ->join('locales','ingresos.idlocal','=','locales.id')
                ->join('users','ingresos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('ingresos.id','ingresos.idijudicial','ingresos.idlocal',
                'ingresos.idusuario','users.usuario','ingresos.numero_ingreso','ingresos.fecha_ingreso',
                'ingresos.cantidad_expediente','ingresos.anulado','ingresos.verificado','ingresos.observacion','ingresos.condicion')
                ->where('ingresos.idijudicial','=',$instancia)
                ->whereYear('ingresos.fecha_ingreso','=',$anio)
                ->orderBy('ingresos.id','desc')->paginate(25);
            }else{
                $consultas= Ingreso::join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
                ->join('locales','ingresos.idlocal','=','locales.id')
                ->join('users','ingresos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('ingresos.id','ingresos.idijudicial','ingresos.idlocal',
                'ingresos.idusuario','users.usuario','ingresos.numero_ingreso','ingresos.fecha_ingreso',
                'ingresos.cantidad_expediente','ingresos.anulado','ingresos.verificado','ingresos.observacion','ingresos.condicion')
                ->where('ingresos.idijudicial','=',$instancia)
                ->whereYear('ingresos.fecha_ingreso','=',$anio)
                ->where('ingresos.'.$criterio,'like','%'.$buscar.'%')
                ->orderBy('ingresos.id','desc')->paginate(25);
            
            }
        }else{
            if($buscar==''){
                $consultas= Ingreso::join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
                ->join('locales','ingresos.idlocal','=','locales.id')
                ->join('users','ingresos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('ingresos.id','ingresos.idijudicial','ingresos.idlocal',
                'ingresos.idusuario','users.usuario','ingresos.numero_ingreso','ingresos.fecha_ingreso',
                'ingresos.cantidad_expediente','ingresos.anulado','ingresos.verificado','ingresos.observacion','ingresos.condicion')
                ->where('ingresos.idijudicial','=',$instancia)
                ->whereYear('ingresos.fecha_ingreso','=',$anio)
                ->where('personas.id','=',$idpersona)
                ->orderBy('ingresos.id','desc')->paginate(25);
            }else{
                $consultas= Ingreso::join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
                ->join('locales','ingresos.idlocal','=','locales.id')
                ->join('users','ingresos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('ingresos.id','ingresos.idijudicial','ingresos.idlocal',
                'ingresos.idusuario','users.usuario','ingresos.numero_ingreso','ingresos.fecha_ingreso',
                'ingresos.cantidad_expediente','ingresos.anulado','ingresos.verificado','ingresos.observacion','ingresos.condicion')
                ->where('ingresos.idijudicial','=',$instancia)
                ->whereYear('ingresos.fecha_ingreso','=',$anio)
                ->where('personas.id','=',$idpersona)
                ->where('ingresos.'.$criterio,'like','%'.$buscar.'%')
                ->orderBy('ingresos.id','desc')->paginate(25);
            
            }
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
    //busqueda por fecha
    public function listado(Request $request)
    {
        if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;
        $fecha=$request->fecha;
        $instancia=$request->instancia;
        $date = Carbon::now();
        $consulta=DB::select('SELECT u.idpersona,upper(r.nombre) as rol1 from personas p,users u,roles r
        where p.id=u.idpersona and r.id=u.idrol and 
        u.id='.Auth::user()->id);
        $idpersona='';
        $rolp='';
        foreach($consulta as $c){
            $idpersona=$c->idpersona;
            $rolp=$c->rol1;
        }
       
        if($rolp=='ADMINISTRADOR DEL SISTEMA'){
            if($buscar==''){
                $consultas= Ingreso::join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
                ->join('locales','ingresos.idlocal','=','locales.id')
                ->join('users','ingresos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('ingresos.id','ingresos.idijudicial','ingresos.idlocal',
                'ingresos.idusuario','users.usuario','ingresos.numero_ingreso','ingresos.fecha_ingreso',
              
                'ingresos.cantidad_expediente','ingresos.anulado','ingresos.verificado','ingresos.observacion','ingresos.condicion')
                ->where('ingresos.idijudicial','=',$instancia)
                ->whereDate('ingresos.fecha_ingreso','=',$fecha)
                ->orderBy('ingresos.id','desc')->paginate(25);
            }else{
                $consultas= Ingreso::join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
                ->join('locales','ingresos.idlocal','=','locales.id')
                ->join('users','ingresos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('ingresos.id','ingresos.idijudicial','ingresos.idlocal',
                'ingresos.idusuario','users.usuario','ingresos.numero_ingreso','ingresos.fecha_ingreso',
                'ingresos.cantidad_expediente','ingresos.anulado','ingresos.verificado','ingresos.observacion','ingresos.condicion')
                ->where('ingresos.idijudicial','=',$instancia)
                ->whereDate('ingresos.fecha_ingreso','=',$fecha)
                ->where('ingresos.'.$criterio,'like','%'.$buscar.'%')
                ->orderBy('ingresos.id','desc')->paginate(25);
            
            }
        }else{
            if($buscar==''){
                $consultas= Ingreso::join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
                ->join('locales','ingresos.idlocal','=','locales.id')
                ->join('users','ingresos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('ingresos.id','ingresos.idijudicial','ingresos.idlocal',
                'ingresos.idusuario','users.usuario','ingresos.numero_ingreso','ingresos.fecha_ingreso',
                'ingresos.cantidad_expediente','ingresos.anulado','ingresos.verificado','ingresos.observacion','ingresos.condicion')
                ->where('ingresos.idijudicial','=',$instancia)
                ->whereDate('ingresos.fecha_ingreso','=',$fecha)
                ->where('personas.id','=',$idpersona)
                ->orderBy('ingresos.id','desc')->paginate(25);
            }else{
                $consultas= Ingreso::join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
                ->join('locales','ingresos.idlocal','=','locales.id')
                ->join('users','ingresos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('ingresos.id','ingresos.idijudicial','ingresos.idlocal',
                'ingresos.idusuario','users.usuario','ingresos.numero_ingreso','ingresos.fecha_ingreso',
                'ingresos.cantidad_expediente','ingresos.anulado','ingresos.verificado','ingresos.observacion','ingresos.condicion')
                ->where('ingresos.idijudicial','=',$instancia)
                ->whereDate('ingresos.fecha_ingreso','=',$fecha)
                ->where('personas.id','=',$idpersona)
                ->where('ingresos.'.$criterio,'like','%'.$buscar.'%')
                ->orderBy('ingresos.fid','desc')->paginate(25);
            
            }
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
    //fin busqueda por fecha
    public function obtenerTotal(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consulta=DB::select('select count(c.id) as total from ingresos c');
        return ['consulta' =>$consulta];
    }
    public function obtenerCodigo(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consulta=DB::select('select c.numero_ingreso as codigo from ingresos c 
        order by id desc limit 1');
        return ['consulta' =>$consulta];
    }
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro=new Ingreso();
        $registro->idijudicial=$request->idijudicial;
        $registro->idlocal=$request->idlocal;
        $registro->idusuario=$request->idusuario;
        $registro->numero_ingreso=$request->numero_ingreso;
        $registro->fecha_ingreso=$request->fecha_ingreso;
        $registro->cantidad_expediente=$request->cantidad_expediente;
        $registro->expediente_digitado=$request->expediente_digitado;
        $registro->verificado=$request->verificado;
        $registro->anulado='NO';
        $registro->observacion=$request->observacion;
        $registro->condicion='1';
        $registro->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= Ingreso::findOrFail($request->id);
        $registro->idlocal=$request->idlocal;
        $registro->cantidad_expediente=$request->cantidad_expediente;
        $registro->expediente_digitado=$request->expediente_digitado;
        $registro->observacion=$request->observacion;
        $registro->condicion='1';
        $registro->save();
    } 
    public function obtenerTotalNumero(Request $request){
        if(!$request->ajax()) return redirect('/');

        $numero=$request->numero;
        $consulta= DB::select('select count(e.id) as total from ingresos e 
        where e.anulado="NO" and e.numero_ingreso='."'".$numero."'");
        return ['consulta' =>$consulta];
       
    }
    public function obtenerId(Request $request){
        if(!$request->ajax()) return redirect('/');

        $numero=$request->numero;
        $consulta= DB::select('select e.id as id from ingresos e 
        where e.numero_ingreso='.$numero.' limit 1');
        return ['consulta' =>$consulta];
       
    }
    public function obtenerProcedencia(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $consulta= Ingreso::join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
                ->join('locales','ingresos.idlocal','=','locales.id')
                ->join('users','ingresos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('ingresos.id','ingresos.idijudicial','ingresos.idlocal','distrito_judiciales.nombre as distrito','provincia_judiciales.nombre as provincia',
                'organo_judiciales.nombre as organo','instancia_judiciales.nombre as instancia','local_judiciales.nombre as direccion',
                'ingresos.idusuario','users.usuario','ingresos.numero_ingreso','ingresos.fecha_ingreso',
                'ingresos.cantidad_expediente','ingresos.anulado','ingresos.verificado','ingresos.observacion','ingresos.condicion')
                ->where('ingresos.id','=',$id)->take(1)->get();

            return ['consulta' =>$consulta];
    }
    public function obtenerCantidadExpediente(Request $request){
        if(!$request->ajax()) return redirect('/');

        $numero=$request->numero;
        $consulta= DB::select('select e.cantidad_expediente as cantidad from ingresos e 
        where e.numero_ingreso='."'".$numero."' limit 1");
        return ['consulta' =>$consulta];
    }
    public function actualizarRegistro(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= Ingreso::findOrFail($request->id);
        $registro->expediente_digitado=$request->digitado;
        $registro->verificado='SI';
        $registro->condicion='1';
        $registro->save();
    }
    public function obtenerTotalVerificado(Request $request){
        if(!$request->ajax()) return redirect('/');

        $numero=$request->numero;
        $consulta= DB::select('select expediente_digitado as acumulado from ingresos 
        where id='.$numero.' and condicion=1 limit 1');
        return ['consulta' =>$consulta];
    }
    public function obtenerTotal1(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consulta=DB::select('select count(c.id) as total from ingresos c where c.anulado="NO" and c.condicion=1;');
        return ['consulta' =>$consulta];
    }
    public function obtenerTotal2(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consulta=DB::select('select count(c.id) as total from ingresos c where c.verificado="SI" and c.anulado="NO" and c.condicion=1;');
        return ['consulta' =>$consulta];
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $consulta= Ingreso::findOrFail($request->id);
        $consulta->anulado='SI';
        $consulta->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $consulta= Ingreso::findOrFail($request->id);
        $consulta->anulado='NO';
        $consulta->save();
    }
    // FUNCIONES PARA USUARIO DE ODECMA
    public function actualizarCantidadExpediente(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        if($request->idingreso=='' || $request->idingreso==null){
            $consulta=DB::select('select id from ingresos  where numero_ingreso='.$request->numero_ingreso.'
            order by id desc limit 1');
            if(count($consulta)>0){
                foreach($consulta as $c){
                    $idingreso=$c->id;
                }
            }else{
                $idingreso = 0;
            }
            
            
        }else{
            $idingreso=$request->idingreso;
        }
        if((int)$idingreso>0){
            $consulta1=DB::select('select id,cantidad_expediente,expediente_digitado from ingresos  where id='.$idingreso.'
            order by id desc limit 1');
            foreach($consulta1 as $c){
                $cantidad1=$c->cantidad_expediente;
                $cantidad2=$c->expediente_digitado;
            }
            $ncantidad1=((int)$cantidad1+1);
            $ncantidad2=((int)$cantidad2+1);
            $registro= Ingreso::findOrFail($idingreso);
            $registro->cantidad_expediente=$ncantidad1;
            $registro->expediente_digitado=$ncantidad2;
        
            $registro->save();
        }
        
    }
}

