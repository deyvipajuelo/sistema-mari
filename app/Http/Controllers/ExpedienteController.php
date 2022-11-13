<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expediente;
use App\Models\DetalleProcesal;
use App\Models\DetalleMateria;
use App\Models\ExpedienteAnulado;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ExpedienteController extends Controller
{
    public function index(Request $request)
    {
       if(!$request->ajax()) return redirect('/');

        $buscar=$request->buscar;
        $criterio=$request->criterio;
        $paquete=$request->numero_ingreso;
        
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
                $consultas= DB::select('SELECT e.id,e.idingreso,ing.numero_ingreso,e.codigo,e.responsable,e.idespecialidad,e.numero_origen,e.idtexpediente,e.numero_folio,
                concat(e.numero_expediente,"-",e.anio_expediente)  as numero_expediente,e.numero_cuaderno,e.idestado,e.idtarchivo,e.fecha_conclusion,
                e.idtconclusion,e.fecha_recepcion,e.idlocal,e.anaquel,e.paquete,e.observacion,i.nombre as instancia,e.idusuario,u.usuario,e.condicion
                FROM expedientes e,ingresos ing,especialidades es,tipo_expedientes te,estados est,tipo_archivos ta,tipo_conclusiones tc,
                locales l,users u,instancia_judiciales i
                WHERE ing.id=e.idingreso and es.id=e.idespecialidad and te.id=e.idtexpediente and est.id=e.idestado and ta.id=e.idtarchivo and
                tc.id=e.idtconclusion and l.id=e.idlocal and u.id=e.idusuario and i.id=ing.idijudicial and ing.numero_ingreso="'.$paquete.'" and 
                e.verificado=0 order by e.id desc');
            }else{
                $consultas= DB::select('SELECT e.id,e.idingreso,ing.numero_ingreso,e.codigo,e.responsable,e.idespecialidad,e.numero_origen,e.idtexpediente,e.numero_folio,
                concat(e.numero_expediente,"-",e.anio_expediente)  as numero_expediente,e.numero_cuaderno,e.idestado,e.idtarchivo,e.fecha_conclusion,
                e.idtconclusion,e.fecha_recepcion,e.idlocal,e.anaquel,e.paquete,e.observacion,i.nombre as instancia,e.idusuario,u.usuario,e.condicion
                FROM expedientes e,ingresos ing,especialidades es,tipo_expedientes te,estados est,tipo_archivos ta,tipo_conclusiones tc,
                locales l,users u,instancia_judiciales i
                WHERE ing.id=e.idingreso and es.id=e.idespecialidad and te.id=e.idtexpediente and est.id=e.idestado and ta.id=e.idtarchivo and
                tc.id=e.idtconclusion and l.id=e.idlocal and u.id=e.idusuario and i.id=ing.idijudicial and ing.numero_ingreso="'.$paquete.'" and 
                e.verificado=0 and e.'.$criterio.' like "%'.$buscar.'%" order by e.id desc');
            
            }
        }else{
            if($buscar==''){
                $consultas= DB::select('SELECT e.id,e.idingreso,ing.numero_ingreso,e.codigo,e.responsable,e.idespecialidad,e.numero_origen,e.idtexpediente,e.numero_folio,
                concat(e.numero_expediente,"-",e.anio_expediente)  as numero_expediente,e.numero_cuaderno,e.idestado,e.idtarchivo,e.fecha_conclusion,
                e.idtconclusion,e.fecha_recepcion,e.idlocal,e.anaquel,e.paquete,e.observacion,i.nombre as instancia,e.idusuario,u.usuario,e.condicion
                FROM expedientes e,ingresos ing,especialidades es,tipo_expedientes te,estados est,tipo_archivos ta,tipo_conclusiones tc,
                locales l,users u,instancia_judiciales i
                WHERE ing.id=e.idingreso and es.id=e.idespecialidad and te.id=e.idtexpediente and est.id=e.idestado and ta.id=e.idtarchivo and
                tc.id=e.idtconclusion and l.id=e.idlocal and u.id=e.idusuario and i.id=ing.idijudicial and ing.numero_ingreso="'.$paquete.'" and 
                e.verificado=0 order by e.id desc');
            }else{
                $consultas= DB::select('SELECT e.id,e.idingreso,ing.numero_ingreso,e.codigo,e.responsable,e.idespecialidad,e.numero_origen,e.idtexpediente,e.numero_folio,
                concat(e.numero_expediente,"-",e.anio_expediente)  as numero_expediente,e.numero_cuaderno,e.idestado,e.idtarchivo,e.fecha_conclusion,
                e.idtconclusion,e.fecha_recepcion,e.idlocal,e.anaquel,e.paquete,e.observacion,i.nombre as instancia,e.idusuario,u.usuario,e.condicion
                FROM expedientes e,ingresos ing,especialidades es,tipo_expedientes te,estados est,tipo_archivos ta,tipo_conclusiones tc,
                locales l,users u,instancia_judiciales i
                WHERE ing.id=e.idingreso and es.id=e.idespecialidad and te.id=e.idtexpediente and est.id=e.idestado and ta.id=e.idtarchivo and
                tc.id=e.idtconclusion and l.id=e.idlocal and u.id=e.idusuario and i.id=ing.idijudicial and ing.numero_ingreso="'.$paquete.'" and 
                e.verificado=0 and e.'.$criterio.' like "%'.$buscar.'%" order by e.id desc');
            
            }
        }
        
        
        //dd($consultas);
      //  'consultas' =>$consultas
        return $consultas;
        
    } 
    public function store(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
       try{
        DB::beginTransaction();

        $mytime= Carbon::now('America/Lima');

        $solicitud = new Expediente();
        $solicitud->idingreso = $request->idingreso;
        $solicitud->codigo = $request->codigo;
        $solicitud->responsable = $request->responsable;
        $solicitud->idespecialidad = $request->idespecialidad;
        $solicitud->numero_origen = $request->numero_origen;
        $solicitud->anio_expediente = $request->anio_expediente;
        $solicitud->numero_expediente = $request->numero_expediente;
        $solicitud->idtexpediente = $request->idtexpediente;
        $solicitud->numero_folio = $request->folio;
        $solicitud->numero_cuaderno = $request->cuaderno;
        $solicitud->idestado = $request->idestado;
        $solicitud->idtarchivo = $request->idtarchivo;
        $solicitud->fecha_conclusion = $request->fecha_conclusion;
        $solicitud->idtconclusion = $request->idtconclusion;
        $solicitud->fecha_recepcion = $request->fecha_recepcion;
        $solicitud->idlocal = $request->idlocal;
        $solicitud->anaquel = $request->anaquel;
        $solicitud->paquete = $request->paquete;
        $solicitud->observacion = $request->observacion;
        $solicitud->idusuario = $request->idusuario;
        $solicitud->verificado='0';
        $solicitud->condicion='1';
        $solicitud->save();

        $detalles = $request->data1;//Array de detalles
        //Recorro todos los elementos
        foreach($detalles as $ep=>$det)
        {
            $detalle = new DetalleProcesal();
            $detalle->idexpediente = $solicitud->id;
            $detalle->idpprocesal = $det['idpprocesal'];
            $detalle->idcpersona = $det['idcpersona'];
            $detalle->apellido = $det['apellido'];
            $detalle->nombre = $det['nombre'];
            $detalle->condicion = '1';  
            $detalle->save();
        }

        $detalles1 = $request->data2;//Array de detalles
        //Recorro todos los elementos
        foreach($detalles1 as $ep=>$det1)
        {
            $detalle1 = new DetalleMateria();
            $detalle1->idexpediente = $solicitud->id;
            $detalle1->idmateria = $det1['idmateria'];
            $detalle1->condicion = '1';  
            $detalle1->save();
        }

       
        DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }

    }
    public function obtenerCabecera(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id=$request->id;
        $consulta= Expediente::join('ingresos','expedientes.idingreso','=','ingresos.id')
            ->join('especialidades','expedientes.idespecialidad','=','especialidades.id')
            ->join('tipo_expedientes','expedientes.idtexpediente','=','tipo_expedientes.id')
            ->join('estados','expedientes.idestado','=','estados.id')
            ->join('tipo_archivos','expedientes.idtarchivo','=','tipo_archivos.id')
            ->join('tipo_conclusiones','expedientes.idtconclusion','=','tipo_conclusiones.id')
            ->join('locales','expedientes.idlocal','=','locales.id')
            ->join('users','expedientes.idusuario','=','users.id')
            ->join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
            ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
            ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
            ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
            ->join('local_judiciales','instancia_judiciales.idljudicial','=','local_judiciales.id')
            ->select('expedientes.id','expedientes.idingreso','ingresos.numero_ingreso',
            'expedientes.codigo','expedientes.responsable','expedientes.idespecialidad',
            DB::raw('concat(expedientes.anio_expediente,"-",expedientes.numero_expediente)  as expediente_origen'),
            DB::raw('concat(expedientes.numero_expediente,"-",expedientes.anio_expediente,"-",if(expedientes.idtexpediente=1,0,expedientes.numero_cuaderno))  as numero_sistema'),
            'expedientes.created_at as fecha_registro',
            'expedientes.numero_origen','expedientes.idtexpediente','expedientes.numero_folio',
            'expedientes.numero_expediente','expedientes.anio_expediente',
            'expedientes.numero_cuaderno','expedientes.idestado','expedientes.idtarchivo',
            'expedientes.fecha_conclusion','expedientes.idtconclusion','expedientes.fecha_recepcion',
            'expedientes.idlocal','expedientes.anaquel','expedientes.paquete','expedientes.observacion',
            'instancia_judiciales.nombre as instancia','distrito_judiciales.nombre as distrito',
            'provincia_judiciales.nombre as provincia','organo_judiciales.nombre as organo',
            'instancia_judiciales.nombre as instancia','local_judiciales.nombre as direccion','locales.nombre as local1',
            'expedientes.idusuario','users.usuario','expedientes.condicion')
            ->where('expedientes.id','=',$id)
            ->orderBy('expedientes.id','desc')->take(1)->get();

        return ['consulta' =>$consulta];
    }
    public function obtenerDetalle1(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $consulta= DetalleProcesal::join('expedientes','detalle_procesales.idexpediente','=','expedientes.id')
        ->join('parte_procesales','detalle_procesales.idpprocesal','=','parte_procesales.id')
        ->join('clase_personas','detalle_procesales.idcpersona','=','clase_personas.id')
        ->select('detalle_procesales.id','detalle_procesales.idexpediente',
                'detalle_procesales.idpprocesal','detalle_procesales.idcpersona',
                'detalle_procesales.apellido','detalle_procesales.nombre',
                'parte_procesales.nombre as nom_pprocesal','clase_personas.nombre as nom_cpersona',
                'detalle_procesales.condicion')
        ->where('detalle_procesales.idexpediente','=',$id)
        ->orderBy('detalle_procesales.id','asc')->get();

        return ['consulta' =>$consulta];
    }
    public function obtenerDetalle2(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $consulta= DetalleMateria::join('expedientes','detalle_materias.idexpediente','=','expedientes.id')
        ->join('materias','detalle_materias.idmateria','=','materias.id')
        
        ->select('detalle_materias.id','detalle_materias.idexpediente',
                'detalle_materias.idmateria',
                'materias.nombre as nom_materia',
                'detalle_materias.condicion')
        ->where('detalle_materias.idexpediente','=',$id)
        ->orderBy('detalle_materias.id','asc')->get();

        return ['consulta' =>$consulta];
    }
    public function update(Request $request){
        if(!$request->ajax()) return redirect('/');
        $solicitud= Expediente::findOrFail($request->id); 
        $solicitud->responsable = $request->responsable;
        $solicitud->idespecialidad = $request->idespecialidad;
        $solicitud->numero_origen = $request->numero_origen;
        $solicitud->anio_expediente = $request->anio_expediente;
        $solicitud->numero_expediente = $request->numero_expediente;
        $solicitud->idtexpediente = $request->idtexpediente;
        $solicitud->numero_folio = $request->folio;
        $solicitud->numero_cuaderno = $request->cuaderno;
        $solicitud->idestado = $request->idestado;
        $solicitud->idtarchivo = $request->idtarchivo;
        $solicitud->fecha_conclusion = $request->fecha_conclusion;
        $solicitud->idtconclusion = $request->idtconclusion;
        $solicitud->fecha_recepcion = $request->fecha_recepcion;
        $solicitud->idlocal = $request->idlocal;
        $solicitud->anaquel = $request->anaquel;
        $solicitud->paquete = $request->paquete;
        $solicitud->observacion = $request->observacion;
        $solicitud->idusuario = $request->idusuario;
        $solicitud->condicion='1';
        $solicitud->save();
    }
    public function registrarDetalle(Request $request){
        if(!$request->ajax()) return redirect('/');
        $detalle = new DetalleProcesal();
        $detalle->idexpediente = $request->idexpediente;
        $detalle->idpprocesal = $request->idpprocesal;
        $detalle->idcpersona = $request->idcpersona;
        $detalle->apellido = $request->apellido;
        $detalle->nombre = $request->nombre;
        $detalle->condicion = '1';  
        $detalle->save();
    }
    public function registrarDetalle1(Request $request){
        if(!$request->ajax()) return redirect('/');
        $detalle = new DetalleMateria();
        $detalle->idexpediente = $request->idexpediente;
        $detalle->idmateria = $request->idmateria;
        $detalle->condicion = '1';  
        $detalle->save();
    }
    public function desactivarDetalle(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $solicitud= DetalleProcesal::findOrFail($request->id);
        $solicitud->condicion='0';
        $solicitud->save();
    }
    public function activarDetalle(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $solicitud= DetalleProcesal::findOrFail($request->id);
        $solicitud->condicion='1';
        $solicitud->save();

    }
    public function desactivarDetalle1(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $solicitud= DetalleMateria::findOrFail($request->id);
        $solicitud->condicion='0';
        $solicitud->save();
    }
    public function activarDetalle1(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $solicitud= DetalleMateria::findOrFail($request->id);
        $solicitud->condicion='1';
        $solicitud->save();

    }
    public function activarRegistro(Request $request){
        if(!$request->ajax()) return redirect('/');
        $solicitud= Expediente::findOrFail($request->id);
        $solicitud->condicion='1';
        $solicitud->save();
    }
    public function desactivarRegistro(Request $request){
        if(!$request->ajax()) return redirect('/');
        $solicitud= Expediente::findOrFail($request->id);
        $solicitud->condicion='0';
        $solicitud->save();
    }
    public function registrarAnulado(Request $request){
        if(!$request->ajax()) return redirect('/');
        $detalle = new ExpedienteAnulado();
        $detalle->idexpediente = $request->idexpediente;
        $detalle->estado = $request->estado;
        $detalle->motivo = $request->motivo;
        $detalle->idusuario = $request->idusuario;
        $detalle->condicion = '1';  
        $detalle->save();
    }
    public function obtenerEstado(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id=$request->id;
        $consulta= Expediente::join('ingresos','expedientes.idingreso','=','ingresos.id')
            ->select('expedientes.id','expedientes.condicion')
            ->where('expedientes.id','=',$id)
            ->orderBy('expedientes.id','desc')->take(1)->get();

        return ['consulta' =>$consulta];
    }
    public function obtenerExpedienteIngresado(Request $request){
        if(!$request->ajax()) return redirect('/');

        $numero=$request->numero;
        $consulta= DB::select('select count(e.id) as ingresados from expedientes e,ingresos i 
        where i.id=e.idingreso and i.numero_ingreso='."'".$numero."' and e.condicion=1 limit 1");
        return ['consulta' =>$consulta];
    }
    public function obtenerExpedienteVerificado(Request $request){
        if(!$request->ajax()) return redirect('/');

        $numero=$request->numero;
        $consulta= DB::select('select count(e.id) as verificado from expedientes e,ingresos i 
        where i.id=e.idingreso and i.numero_ingreso='."'".$numero."' and e.condicion=1 and e.verificado=1 limit 1");
        return ['consulta' =>$consulta];
    }
    public function obtenerExpedienteSinVerificar(Request $request){
        if(!$request->ajax()) return redirect('/'); 
 
        $numero=$request->numero;
        $rpta=DB::select('SELECT e.id,e.idingreso,ing.numero_ingreso,e.codigo,e.responsable,e.idespecialidad,
        e.numero_origen,e.idtexpediente,e.numero_folio,
        concat(e.numero_expediente,"-",e.anio_expediente)  as numero_expediente,
        e.numero_cuaderno,e.idestado,e.idtarchivo,e.fecha_conclusion,e.idtconclusion,e.fecha_recepcion,
        e.idlocal,e.anaquel,e.paquete,e.observacion,ij.nombre as instancia,e.idusuario,u.usuario,
        e.condicion
        FROM expedientes e,ingresos ing,especialidades es,tipo_expedientes te,estados est,
        tipo_archivos ta,tipo_conclusiones tc,locales l, users u,instancia_judiciales ij
        WHERE ing.id=e.idingreso and es.id=e.idespecialidad and te.id=e.idtexpediente
        and est.id=e.idestado and ta.id=e.idtarchivo and tc.id=e.idtconclusion and l.id=e.idlocal
        and u.id=e.idusuario and ij.id=ing.idijudicial and ing.numero_ingreso='."'".$numero."'".' and e.condicion=1
        and e.verificado=0 order by e.id desc;');
        return ['consulta' =>$rpta];
    }
    public function actualizarRegistro(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idlocal =$request->idlocal;
        $anaquel =$request->anaquel;
        $paquete =$request->paquete;
        $data = $request->data;
        $idexpediente=0;
        foreach($data as $ep=>$dat)
        {
            $idexpediente=$dat['idexpediente'];
            $solicitud= Expediente::findOrFail($idexpediente);
            $solicitud->idlocal = $idlocal;
            $solicitud->anaquel = $anaquel;
            $solicitud->paquete = $paquete;
            $solicitud->save();
        }
        
    }
    public function actualizarRegistro1(Request $request){
        if(!$request->ajax()) return redirect('/');
        
        $data = $request->data;
        $idexpediente=0;
        foreach($data as $ep=>$dat)
        {
            $idexpediente=$dat['idexpediente'];
            $solicitud= Expediente::findOrFail($idexpediente);
            $solicitud->verificado = 1;
            $solicitud->save();
        }
        
    }
    public function actualizarRegistro2(Request $request){
        if(!$request->ajax()) return redirect('/');
        $solicitud= Expediente::findOrFail($request->id);
        $solicitud->idestado = $request->idestado;
        $solicitud->save();
        
    }
    public function actualizar1(Request $request){
        if(!$request->ajax()) return redirect('/');
        $solicitud= Expediente::findOrFail($request->id); 
        $solicitud->responsable = $request->responsable;
        $solicitud->idespecialidad = $request->idespecialidad;
        $solicitud->idtexpediente = $request->idtexpediente;
        $solicitud->numero_folio = $request->folio;
        $solicitud->numero_cuaderno = $request->cuaderno;
        $solicitud->idestado = $request->idestado;
        $solicitud->idtarchivo = $request->idtarchivo;
        $solicitud->fecha_conclusion = $request->fecha_conclusion;
        $solicitud->idtconclusion = $request->idtconclusion;
        $solicitud->fecha_recepcion = $request->fecha_recepcion;
        $solicitud->anaquel = $request->anaquel;
        $solicitud->paquete = $request->paquete;
        $solicitud->observacion = $request->observacion;
        $solicitud->idusuario = $request->idusuario;
        $solicitud->condicion='1';
        $solicitud->save();
    }
    public function obtenerTotalPaqueteUbicado(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id=$request->id;
        $consulta= DB::select('select count(u.id) as total from ubicacion_paquetes u,ingresos i 
        where i.id=u.idingreso and u.idingreso='.$id.' and u.condicion=1 limit 1');
        return ['consulta' =>$consulta];
    }
    public function obtenerTotalPaqueteVerificado(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id=$request->id;
        $consulta= DB::select('select count(p.id) as total from paquete_verificados p,ingresos i 
        where i.id=p.idingreso and p.idingreso='.$id.' and p.condicion=1 and p.verificado=1 limit 1'); 
        return ['consulta' =>$consulta];
    }
    public function obtenerTotal(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consulta=DB::select('select count(e.id) as total from expedientes e where e.verificado=1 and e.condicion=1;');
        return ['consulta' =>$consulta];
    }
    public function obtenerTotal1(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consulta=DB::select('select count(e.id) as total from expedientes e where e.condicion=1;');
        return ['consulta' =>$consulta];
    }
    public function obtenerTotalId(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $consulta=DB::select('select count(e.id) as total from expedientes e,ingresos i where i.id=e.idingreso and e.idingreso='.$id);
        return ['consulta' =>$consulta];
    }
    public function lista(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $consulta=DB::select('SELECT e.id as idexpediente,e.idingreso,e.anaquel,e.paquete,e.idlocal 
        FROM expedientes e,ingresos i WHERE i.id=e.idingreso and e.condicion=1 and e.verificado=1 and e.idingreso='.$id);
        return ['consulta' =>$consulta];
    }
    // PARA ODECMA
    public function expedienteConFiltro(Request $request){
        if(!$request->ajax()) return redirect('/');
        $fecha1=$request->fecha1;
        $fecha2=$request->fecha2;
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        $miRegistro=$request->miRegistro;
        $date = Carbon::now();
        $iduser=Auth::user()->id;
        if($fecha1=='' || $fecha1 ==null){
            $fecha1=$date->format('Y-m-d');
        }
        if($fecha2=='' || $fecha2 ==null){
            $fecha2=$date->format('Y-m-d');
        }
        if($miRegistro==1){
            if($buscar==''){
                $consultas= DB::select('SELECT e.id,e.idingreso,ing.numero_ingreso,e.codigo,e.responsable,e.idespecialidad,e.numero_origen,e.idtexpediente,e.numero_folio,
                concat(e.numero_expediente,"-",e.anio_expediente)  as numero_expediente,e.numero_cuaderno,e.idestado,e.idtarchivo,e.fecha_conclusion,
                e.idtconclusion,e.fecha_recepcion,e.idlocal,e.anaquel,e.paquete,e.observacion,i.nombre as instancia,e.idusuario,u.usuario,e.condicion,e.estado_odecma,e.created_at as fecha_registro,e.verificado
                FROM expedientes e,ingresos ing,especialidades es,tipo_expedientes te,estados est,tipo_archivos ta,tipo_conclusiones tc,
                locales l,users u,instancia_judiciales i
                WHERE ing.id=e.idingreso and es.id=e.idespecialidad and te.id=e.idtexpediente and est.id=e.idestado and ta.id=e.idtarchivo and
                tc.id=e.idtconclusion and l.id=e.idlocal and u.id=e.idusuario and i.id=ing.idijudicial and e.verificado=0 and e.idusuario='.$iduser.' and date(e.created_at) between "'.$fecha1.'" and "'.$fecha2.'"
                order by e.id desc');
            }else{
                $consultas= DB::select('SELECT e.id,e.idingreso,ing.numero_ingreso,e.codigo,e.responsable,e.idespecialidad,e.numero_origen,e.idtexpediente,e.numero_folio,
                concat(e.numero_expediente,"-",e.anio_expediente)  as numero_expediente,e.numero_cuaderno,e.idestado,e.idtarchivo,e.fecha_conclusion,
                e.idtconclusion,e.fecha_recepcion,e.idlocal,e.anaquel,e.paquete,e.observacion,i.nombre as instancia,e.idusuario,u.usuario,e.condicion,e.estado_odecma,e.created_at as fecha_registro,e.verificado
                FROM expedientes e,ingresos ing,especialidades es,tipo_expedientes te,estados est,tipo_archivos ta,tipo_conclusiones tc,
                locales l,users u,instancia_judiciales i
                WHERE ing.id=e.idingreso and es.id=e.idespecialidad and te.id=e.idtexpediente and est.id=e.idestado and ta.id=e.idtarchivo and
                tc.id=e.idtconclusion and l.id=e.idlocal and u.id=e.idusuario and i.id=ing.idijudicial and date(e.created_at) between "'.$fecha1.'" and "'.$fecha2.'" and 
                e.verificado=0 and e.idusuario='.$iduser.' and '.$criterio.' like "%'.$buscar.'%" order by e.id desc');
            
            }
        }else{
            if($buscar==''){
                $consultas= DB::select('SELECT e.id,e.idingreso,ing.numero_ingreso,e.codigo,e.responsable,e.idespecialidad,e.numero_origen,e.idtexpediente,e.numero_folio,
                concat(e.numero_expediente,"-",e.anio_expediente)  as numero_expediente,e.numero_cuaderno,e.idestado,e.idtarchivo,e.fecha_conclusion,
                e.idtconclusion,e.fecha_recepcion,e.idlocal,e.anaquel,e.paquete,e.observacion,i.nombre as instancia,e.idusuario,u.usuario,e.condicion,e.estado_odecma,e.created_at as fecha_registro,e.verificado
                FROM expedientes e,ingresos ing,especialidades es,tipo_expedientes te,estados est,tipo_archivos ta,tipo_conclusiones tc,
                locales l,users u,instancia_judiciales i
                WHERE ing.id=e.idingreso and es.id=e.idespecialidad and te.id=e.idtexpediente and est.id=e.idestado and ta.id=e.idtarchivo and
                tc.id=e.idtconclusion and l.id=e.idlocal and u.id=e.idusuario and i.id=ing.idijudicial and e.verificado=0 and date(e.created_at) between "'.$fecha1.'" and "'.$fecha2.'"
                order by e.id desc');
            }else{
                $consultas= DB::select('SELECT e.id,e.idingreso,ing.numero_ingreso,e.codigo,e.responsable,e.idespecialidad,e.numero_origen,e.idtexpediente,e.numero_folio,
                concat(e.numero_expediente,"-",e.anio_expediente)  as numero_expediente,e.numero_cuaderno,e.idestado,e.idtarchivo,e.fecha_conclusion,
                e.idtconclusion,e.fecha_recepcion,e.idlocal,e.anaquel,e.paquete,e.observacion,i.nombre as instancia,e.idusuario,u.usuario,e.condicion,e.estado_odecma,e.created_at as fecha_registro,e.verificado
                FROM expedientes e,ingresos ing,especialidades es,tipo_expedientes te,estados est,tipo_archivos ta,tipo_conclusiones tc,
                locales l,users u,instancia_judiciales i
                WHERE ing.id=e.idingreso and es.id=e.idespecialidad and te.id=e.idtexpediente and est.id=e.idestado and ta.id=e.idtarchivo and
                tc.id=e.idtconclusion and l.id=e.idlocal and u.id=e.idusuario and i.id=ing.idijudicial and date(e.created_at) between "'.$fecha1.'" and "'.$fecha2.'" and 
                e.verificado=0 and '.$criterio.' like "%'.$buscar.'%" order by e.id desc');
            
            }
        }
       
        return $consultas;
    }
    public function expedienteGeneral(Request $request){
        if(!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        
        $consultas= DB::select('SELECT e.id,e.idingreso,ing.numero_ingreso,e.codigo,e.responsable,e.idespecialidad,e.numero_origen,e.idtexpediente,e.numero_folio,
            concat(e.numero_expediente,"-",e.anio_expediente)  as numero_expediente,e.numero_cuaderno,e.idestado,e.idtarchivo,e.fecha_conclusion,
            e.idtconclusion,e.fecha_recepcion,e.idlocal,e.anaquel,e.paquete,e.observacion,i.nombre as instancia,e.idusuario,u.usuario,e.condicion,e.estado_odecma,e.created_at as fecha_registro,e.verificado
            FROM expedientes e,ingresos ing,especialidades es,tipo_expedientes te,estados est,tipo_archivos ta,tipo_conclusiones tc,
            locales l,users u,instancia_judiciales i
            WHERE ing.id=e.idingreso and es.id=e.idespecialidad and te.id=e.idtexpediente and est.id=e.idestado and ta.id=e.idtarchivo and
            tc.id=e.idtconclusion and l.id=e.idlocal and u.id=e.idusuario and i.id=ing.idijudicial 
            and concat('.$criterio.') like "%'.$buscar.'%" order by e.id desc');
        return $consultas;
    }
    public function registrarOdecma(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
       try{
        DB::beginTransaction();

        $mytime= Carbon::now('America/Lima');
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
        $solicitud = new Expediente();
        $solicitud->idingreso = $idingreso;
        $solicitud->codigo = $request->codigo;
        $solicitud->responsable = $request->responsable;
        $solicitud->idespecialidad = $request->idespecialidad;
        $solicitud->numero_origen = $request->numero_origen;
        $solicitud->anio_expediente = $request->anio_expediente;
        $solicitud->numero_expediente = $request->numero_expediente;
        $solicitud->idtexpediente = $request->idtexpediente;
        $solicitud->numero_folio = $request->folio;
        $solicitud->numero_cuaderno = $request->cuaderno;
        $solicitud->idestado = $request->idestado;
        $solicitud->idtarchivo = $request->idtarchivo;
        $solicitud->fecha_conclusion = $request->fecha_conclusion;
        $solicitud->idtconclusion = $request->idtconclusion;
        $solicitud->fecha_recepcion = $request->fecha_recepcion;
        $solicitud->idlocal = $request->idlocal;
        $solicitud->anaquel = $request->anaquel;
        $solicitud->paquete = $request->paquete;
        $solicitud->observacion = $request->observacion;
        $solicitud->idusuario = $request->idusuario;
        $solicitud->verificado='0';
        $solicitud->condicion='1';
        $solicitud->estado_odecma='POR EMPAQUETAR';
        $solicitud->save();

        $detalles = $request->data1;//Array de detalles
        //Recorro todos los elementos
        foreach($detalles as $ep=>$det)
        {
            $detalle = new DetalleProcesal();
            $detalle->idexpediente = $solicitud->id;
            $detalle->idpprocesal = $det['idpprocesal'];
            $detalle->idcpersona = $det['idcpersona'];
            $detalle->apellido = $det['apellido'];
            $detalle->nombre = $det['nombre'];
            $detalle->condicion = '1';  
            $detalle->save();
        }

        $detalles1 = $request->data2;//Array de detalles
        //Recorro todos los elementos
        foreach($detalles1 as $ep=>$det1)
        {
            $detalle1 = new DetalleMateria();
            $detalle1->idexpediente = $solicitud->id;
            $detalle1->idmateria = $det1['idmateria'];
            $detalle1->condicion = '1';  
            $detalle1->save();
        }

       
        DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }

    }
    public function actualizarOdecma(Request $request){
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
        $solicitud= Expediente::findOrFail($request->id);
        $solicitud->idingreso = $idingreso;
        $solicitud->responsable = $request->responsable;
        $solicitud->responsable = $request->responsable;
        $solicitud->idespecialidad = $request->idespecialidad;
        $solicitud->numero_origen = $request->numero_origen;
        $solicitud->anio_expediente = $request->anio_expediente;
        $solicitud->numero_expediente = $request->numero_expediente;
        $solicitud->idtexpediente = $request->idtexpediente;
        $solicitud->numero_folio = $request->folio;
        $solicitud->numero_cuaderno = $request->cuaderno;
        $solicitud->idestado = $request->idestado;
        $solicitud->idtarchivo = $request->idtarchivo;
        $solicitud->fecha_conclusion = $request->fecha_conclusion;
        $solicitud->idtconclusion = $request->idtconclusion;
        $solicitud->fecha_recepcion = $request->fecha_recepcion;
        $solicitud->idlocal = $request->idlocal;
        $solicitud->anaquel = $request->anaquel;
        $solicitud->paquete = $request->paquete;
        $solicitud->observacion = $request->observacion;
        //$solicitud->idusuario = $request->idusuario;
        $solicitud->condicion='1';
        if($idingreso>0){
            $solicitud->estado_odecma='EMPAQUETADO';
        }
        $solicitud->save();
    }
    public function empaquetarExpediente(Request $request){
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
        $detalles = $request->data;//Array de detalles
        //Recorro todos los elementos
        foreach($detalles as $ep=>$det)
        {
            $idexpediente=$det['idexpediente'];
            $detalle = Expediente::findOrFail($idexpediente);
            $detalle->idingreso = $idingreso;
            $detalle->estado_odecma='EMPAQUETADO';
            $detalle->save();
        }
        
        
    }
}

