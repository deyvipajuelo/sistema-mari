<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Legajo;
use App\Models\DetalleLegajo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LegajoController extends Controller
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
                $consultas= Legajo::join('instancia_judiciales','legajos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('users','legajos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('legajos.id','legajos.idijudicial','instancia_judiciales.nombre as instancia',
                'provincia_judiciales.nombre as provincia','distrito_judiciales.nombre as distrito','users.usuario','legajos.asunto','legajos.anaquel',
                'legajos.paquete','legajos.condicion')
                ->whereYear('legajos.created_at','=',$anio)
                ->orderBy('legajos.id','desc')->paginate(25);
            }else{
                $consultas= Legajo::join('instancia_judiciales','legajos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('users','legajos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('legajos.id','legajos.idijudicial','instancia_judiciales.nombre as instancia',
                'provincia_judiciales.nombre as provincia','distrito_judiciales.nombre as distrito','users.usuario','legajos.asunto','legajos.anaquel',
                'legajos.paquete','legajos.condicion')
                ->whereYear('legajos.created_at','=',$anio)
                ->where('legajos.'.$criterio,'like','%'.$buscar.'%')
                ->orderBy('legajos.id','desc')->paginate(25);
            
            }
        }else{
            if($buscar==''){
                $consultas= Legajo::join('instancia_judiciales','legajos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('users','legajos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('legajos.id','legajos.idijudicial','instancia_judiciales.nombre as instancia',
                'provincia_judiciales.nombre as provincia','distrito_judiciales.nombre as distrito','users.usuario','legajos.asunto','legajos.anaquel',
                'legajos.paquete','legajos.condicion')
                ->whereYear('legajos.created_at','=',$anio)
                
                ->orderBy('legajos.id','desc')->paginate(25);
            }else{
                $consultas= Legajo::join('instancia_judiciales','legajos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('users','legajos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('legajos.id','legajos.idijudicial','instancia_judiciales.nombre as instancia',
                'provincia_judiciales.nombre as provincia','distrito_judiciales.nombre as distrito','users.usuario','legajos.asunto','legajos.anaquel',
                'legajos.paquete','legajos.condicion')
                ->whereYear('legajos.created_at','=',$anio)
                
                ->where('legajos.'.$criterio,'like','%'.$buscar.'%')
                ->orderBy('legajos.id','desc')->paginate(25);
            
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
    public function store(Request $request)
    {
       if(!$request->ajax()) return redirect('/');
       try{
        DB::beginTransaction();

        $mytime= Carbon::now('America/Lima');

        $solicitud = new Legajo();
        $solicitud->idijudicial = $request->idijudicial;
        $solicitud->asunto = $request->asunto;
        $solicitud->anaquel = $request->anaquel;
        $solicitud->paquete = $request->paquete;
        $solicitud->idusuario = $request->idusuario;
        
        $solicitud->condicion='1';
        $solicitud->save();

        $detalles = $request->data1;//Array de detalles
        //Recorro todos los elementos
        foreach($detalles as $ep=>$det)
        {
            $detalle = new DetalleLegajo();
            $detalle->idlegajo = $solicitud->id;
            $detalle->descripcion = $det['descripcion'];
            $detalle->observacion = $det['observacion'];
            $detalle->anio = $det['anio_legajo'];
            $detalle->folio = $det['folio'];
            $detalle->estado = $det['estado_legajo'];
            $detalle->condicion = '1';  
            $detalle->save();
        }

       
       
        DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }

    }
    public function obtenerCabecera(Request $request){
        if(!$request->ajax()) return redirect('/');

        $id=$request->id;
        $consultas= Legajo::join('instancia_judiciales','legajos.idijudicial','=','instancia_judiciales.id')
                ->join('organo_judiciales','instancia_judiciales.idojudicial','=','organo_judiciales.id')
                ->join('provincia_judiciales','organo_judiciales.idpjudicial','=','provincia_judiciales.id')
                ->join('distrito_judiciales','provincia_judiciales.iddjudicial','=','distrito_judiciales.id')
                ->join('users','legajos.idusuario','=','users.id')
                ->join('personas','users.idpersona','=','personas.id')
                ->select('legajos.id','legajos.idijudicial','organo_judiciales.id as idojudicial','provincia_judiciales.id as idpjudicial',
                'distrito_judiciales.id as iddjudicial','instancia_judiciales.nombre as instancia',
                'provincia_judiciales.nombre as provincia','distrito_judiciales.nombre as distrito','users.usuario','legajos.asunto','legajos.anaquel',
                'legajos.paquete','legajos.condicion')
            ->where('legajos.id','=',$id)
            ->orderBy('legajos.id','desc')->take(1)->get();
        
        return ['consultas' =>$consultas];
    }
    public function obtenerDetalle1(Request $request){
        if(!$request->ajax()) return redirect('/');
        $id=$request->id;
        $consulta= DetalleLegajo::join('legajos','detalle_legajos.idlegajo','=','legajos.id')
        ->select('detalle_legajos.id','detalle_legajos.idlegajo',
                'detalle_legajos.descripcion','detalle_legajos.observacion',
                'detalle_legajos.anio as anio_legajo','detalle_legajos.folio',
                'detalle_legajos.estado as estado_legajo',
                'detalle_legajos.condicion')
        ->where('detalle_legajos.idlegajo','=',$id)
        ->orderBy('detalle_legajos.id','asc')->get();

        return ['consulta' =>$consulta];
    }
    public function update(Request $request){
        if(!$request->ajax()) return redirect('/');
        $solicitud= Legajo::findOrFail($request->id); 
        $solicitud->idijudicial = $request->idijudicial;
        $solicitud->asunto = $request->asunto;
        $solicitud->anaquel = $request->anaquel;
        $solicitud->paquete = $request->paquete;
        $solicitud->idusuario = $request->idusuario;
        $solicitud->condicion='1';
        $solicitud->save();
    }
    public function registrarDetalle(Request $request){
        if(!$request->ajax()) return redirect('/');
        $detalle = new DetalleLegajo();
        $detalle->idlegajo = $request->idlegajo;
        $detalle->descripcion = $request->descripcion;
        $detalle->observacion = $request->observacion;
        $detalle->anio = $request->anio;
        $detalle->folio = $request->folio;
        $detalle->estado = $request->estado;
        $detalle->condicion = '1';  
        $detalle->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= Legajo::findOrFail($request->id);
        $registro->condicion='0';
        $registro->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= Legajo::findOrFail($request->id);
        $registro->condicion='1';
        $registro->save();
    }
    public function desactivarDetalle(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $solicitud= DetalleLegajo::findOrFail($request->id);
        $solicitud->condicion='0';
        $solicitud->save();
    }
    public function activarDetalle(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $solicitud= DetalleLegajo::findOrFail($request->id);
        $solicitud->condicion='1';
        $solicitud->save();

    }
    public function obtenerTotal(Request $request){
        if(!$request->ajax()) return redirect('/');
        $consulta=DB::select('select count(id) as total from legajos where  condicion=1;');
        return ['consulta' =>$consulta];
    }
    public function reporte(Request $request,$id){
        //if(!$request->ajax()) return redirect('/');
        //$id=$request->id;
        
        $id=base64_decode($id);
        $sql='SELECT  @i := @i + 1 contador,d.id,d.idlegajo,d.descripcion,d.observacion,d.anio,d.folio,d.estado,d.condicion
        FROM detalle_legajos d,legajos l
        cross join (select @i := 0) m
        WHERE l.id=d.idlegajo and d.condicion=1 and d.idlegajo='.$id;
        $consulta=DB::select($sql);
        $cabecera=DB::select('select l.id,UPPER(i.nombre) as instancia, UPPER(p.nombre) as provincia,UPPER(d.nombre) as distrito,UPPER(l.asunto) as asunto,l.anaquel,l.paquete
        from legajos l,instancia_judiciales i,organo_judiciales o,provincia_judiciales p,distrito_judiciales d
        where d.id=p.iddjudicial and p.id=o.idpjudicial and o.id=i.idojudicial and i.id=l.idijudicial and l.condicion=1 and l.id='.$id);
        
       /*
        $c=count($consulta);
        $hojas=0;
        $cantidad=15; //se defiine la cantidad de registros por hoja
        if($cantidad<$c){
            $hojas=number_format(ceil($c/$cantidad),0);
        }else{
            $hojas=1;
        }
        
        $padre=array();
        $lista=array();
        $hijo = (array) $cabecera;
        $detalle=(array) $consulta;
        $texpedientes=0;
        $sumafolios=0;
        
        for($m = 0; $m < $hojas; $m++){
            $conteo=$m+1;
            if($conteo==1){
                if($hojas>1){
                    for($j = 0; $j < $cantidad; $j++){
                        array_push($lista,$detalle[$j]);
                        $n=$cantidad;
                        $nc=$n+$cantidad;//se define nueva cantidad a recorrer
                    }
                }else{
                    for($j = 0; $j < $c; $j++){
                        array_push($lista,$detalle[$j]);
                        $n=$cantidad;
                        $nc=$n+$cantidad;//se define nueva cantidad a recorrer
                    }
                }
                
            }else{
                
                if($conteo<$hojas){
                    for($i = $n; $i < $nc; $i++){
                        array_push($lista,$detalle[$i]);
                        $n=$nc;
                        $nc=$n+$cantidad;
                    }
                }else{
                    for($k = $n; $k < $c; $k++){
                        array_push($lista,$detalle[$k]);  
                       
                    }
                }
            }
            
            array_push($padre,[$lista,$hijo,($m+1),$hojas]);
            //limpiar array lista por cada iteracion
            $lista=[];

        }
        */
        //dd($padre);
        
        $pdf= \PDF::loadView('pdf.Legajospdf',
            ['cabecera'=>$cabecera,'consulta'=>$consulta])->setPaper('a4');
            return $pdf->stream('Legajos.pdf',array("Attachment" => false));
       
    }

}
