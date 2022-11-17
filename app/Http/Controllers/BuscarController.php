<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingreso;
use App\Models\Expediente;
use PDF;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;

class BuscarController extends Controller
{
    public function consultaPaquete(Request $request){
        if(!$request->ajax()) return redirect('/');

        $numero=$request->numero;
        $consulta= DB::select('SELECT e.idingreso,e.id as idexpediente,e.codigo, concat(e.anio_expediente,"-",e.numero_expediente) as expediente,
        te.nombre as tipoexpediente,i.nombre as instancia,e.idestado,
        l.nombre as direccion,e.anaquel,e.paquete,es.nombre as estado,pprocesales.id,pprocesales.parteprocesal,e.condicion
        from expedientes e,ingresos ing, instancia_judiciales i,locales l,estados es,tipo_expedientes te,
        (select persona.id,concat(materia,"\n",persona) as parteprocesal  from
        (select e.id as id, group_concat(if(pp.nombre="Demandante", "DTE", "DDO"),": ",dp.apellido," ",dp.nombre SEPARATOR "\n")  as persona
        from parte_procesales pp,detalle_procesales dp, expedientes e,ingresos i
        where pp.id=dp.idpprocesal and e.id=dp.idexpediente and i.id=e.idingreso 
        and i.numero_ingreso='."'".$numero."'".' and dp.condicion=1 and e.verificado=1 group by e.id) as persona, 
        (select e.id,group_concat(m.nombre SEPARATOR ", ") as materia
        from materias m,detalle_materias dm, expedientes e,ingresos i
        where m.id=dm.idmateria and e.id=dm.idexpediente and i.id=e.idingreso and e.verificado=1 and i.numero_ingreso='."'".$numero."'".' and dm.condicion=1 group by e.id) as pprocesal
        where persona.id=pprocesal.id) as pprocesales
        where ing.id=e.idingreso and i.id=ing.idijudicial and l.id=e.idlocal and es.id=e.idestado and te.id=e.idtexpediente
        and ing.numero_ingreso='."'".$numero."'".' and pprocesales.id=e.id and e.verificado=1 order by e.id desc');
        return ['consulta' =>$consulta];
    }
    public function consultaExpediente(Request $request){
        if(!$request->ajax()) return redirect('/');
        $anio=$request->anio;
        $numero=$request->numero;
        $consulta= DB::select('select e.idingreso,e.id as idexpediente,e.codigo, concat(e.anio_expediente,"-",e.numero_expediente) as expediente,
        te.nombre as tipoexpediente,i.nombre as instancia,ing.numero_ingreso,e.idestado,
        l.nombre as direccion,e.anaquel,e.paquete,es.nombre as estado,pprocesales.id,pprocesales.parteprocesal,e.condicion
        from expedientes e,ingresos ing, instancia_judiciales i,locales l,estados es,tipo_expedientes te,
        (select persona.id,concat(materia,"\n",persona) as parteprocesal  from
        (select e.id as id, group_concat(if(pp.nombre="Demandante", "DTE", "DDO"),": ",dp.apellido," ",dp.nombre SEPARATOR "\n")  as persona
        from parte_procesales pp,detalle_procesales dp, expedientes e,ingresos i
        where pp.id=dp.idpprocesal and e.id=dp.idexpediente and i.id=e.idingreso 
        and e.anio_expediente='."'".$anio."'".' and e.numero_expediente='."'".$numero."'".' and e.verificado=1 and dp.condicion=1 group by e.id) as persona, 
        (select e.id,group_concat(m.nombre SEPARATOR ", ") as materia
        from materias m,detalle_materias dm, expedientes e,ingresos i
        where m.id=dm.idmateria and e.id=dm.idexpediente and i.id=e.idingreso and e.anio_expediente='."'".$anio."'".' and e.numero_expediente='."'".$numero."'".' and e.verificado=1 and dm.condicion=1  group by e.id) as pprocesal
        where persona.id=pprocesal.id) as pprocesales
        where ing.id=e.idingreso and i.id=ing.idijudicial and l.id=e.idlocal and es.id=e.idestado and te.id=e.idtexpediente
        and e.anio_expediente='."'".$anio."'".' and e.numero_expediente='."'".$numero."'".' and e.verificado=1 and pprocesales.id=e.id order by e.id desc');
        return ['consulta' =>$consulta];
    }
    public function consultaParteProcesal(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idpprocesal=$request->idpprocesal;
        $apellido=$request->apellido;
        $nombre=$request->nombre;
        $consulta= DB::select('select e.idingreso,e.id as idexpediente,e.codigo, concat(e.anio_expediente,"-",e.numero_expediente) as expediente,
        te.nombre as tipoexpediente,i.nombre as instancia,e.idestado,
        l.nombre as direccion,e.anaquel,e.paquete,es.nombre as estado,pprocesales.id,pprocesales.parteprocesal,e.condicion
        from expedientes e,ingresos ing, instancia_judiciales i,locales l,estados es,tipo_expedientes te,detalle_procesales dp,
        (select persona.id,concat(materia,"\n",persona) as parteprocesal  from
        (select e.id as id, group_concat(if(pp.nombre="Demandante", "DTE", "DDO"),": ",dp.apellido," ",dp.nombre SEPARATOR "\n")  as persona
        from parte_procesales pp,detalle_procesales dp, expedientes e,ingresos i
        where pp.id=dp.idpprocesal and e.id=dp.idexpediente and i.id=e.idingreso 
        and pp.id='."'".$idpprocesal."'".' and dp.condicion=1 and e.verificado=1 and concat(dp.apellido,dp.nombre) LIKE '."'%".$apellido."%'".' group by e.id) as persona, 
        (select e.id,group_concat(m.nombre SEPARATOR ", ") as materia
        from materias m,detalle_materias dm,detalle_procesales dp,expedientes e
        where m.id=dm.idmateria and e.id=dm.idexpediente and e.id=dp.idexpediente 
        and dp.idpprocesal='."'".$idpprocesal."'".' and e.verificado=1 and dp.condicion=1 and concat(dp.apellido,dp.nombre) LIKE '."'%".$apellido."%'".' group by e.id) as pprocesal
        where persona.id=pprocesal.id) as pprocesales
        where ing.id=e.idingreso and i.id=ing.idijudicial and l.id=e.idlocal and es.id=e.idestado and te.id=e.idtexpediente and e.id=dp.idexpediente
        and dp.idpprocesal='."'".$idpprocesal."'".' and e.verificado=1 and dp.condicion=1 and concat(dp.apellido,dp.nombre) LIKE '."'%".$apellido."%'".' and pprocesales.id=e.id order by e.id desc');
        return ['consulta' =>$consulta];
    }
    public function consultaAnaquel(Request $request){
        if(!$request->ajax()) return redirect('/');
        $idlocal=$request->idlocal;
        $anaquel=$request->anaquel;
        $paquete=$request->paquete;
        $consulta= DB::select('select e.idingreso,e.id as idexpediente,e.codigo, concat(e.anio_expediente,"-",e.numero_expediente) as expediente,
        te.nombre as tipoexpediente,i.nombre as instancia,e.idestado,
        l.nombre as direccion,e.anaquel,e.paquete,es.nombre as estado,pprocesales.id,pprocesales.parteprocesal,e.condicion
        from expedientes e,ingresos ing, instancia_judiciales i,locales l,estados es,tipo_expedientes te,
        (select persona.id,concat(materia,"\n",persona) as parteprocesal  from
        (select e.id as id, group_concat(if(pp.nombre="Demandante", "DTE", "DDO"),": ",dp.apellido," ",dp.nombre SEPARATOR "\n")  as persona
        from parte_procesales pp,detalle_procesales dp, expedientes e,ingresos i
        where pp.id=dp.idpprocesal and e.id=dp.idexpediente and i.id=e.idingreso 
        and e.idlocal='.$idlocal.' and e.anaquel='."'".$anaquel."'".' and e.paquete='."'".$paquete."'".' and e.verificado=1 and dp.condicion=1 group by e.id) as persona, 
        (select e.id,group_concat(m.nombre SEPARATOR ", ") as materia
        from materias m,detalle_materias dm, expedientes e,ingresos i
        where m.id=dm.idmateria and e.id=dm.idexpediente and i.id=e.idingreso and e.idlocal='.$idlocal.' and e.anaquel='."'".$anaquel."'".' and e.paquete='."'".$paquete."'".' and e.verificado=1 and dm.condicion=1 group by e.id) as pprocesal
        where persona.id=pprocesal.id) as pprocesales
        where ing.id=e.idingreso and i.id=ing.idijudicial and l.id=e.idlocal and es.id=e.idestado and te.id=e.idtexpediente
        and e.idlocal='.$idlocal.' and e.anaquel='."'".$anaquel."'".' and e.paquete='."'".$paquete."'".' and e.verificado=1 and pprocesales.id=e.id order by e.id desc');
        return ['consulta' =>$consulta];
    }
    public function reportePaquete(Request $request,$numero){
        $numero=base64_decode($numero);
        //$numero=$request->numero;
        
        $sql='SELECT @i := @i + 1 contador,e.idingreso,e.id as idexpediente,concat(e.numero_expediente,"-",e.anio_expediente,"-",if(e.idtexpediente=1,0,e.numero_cuaderno)) as expediente,
        es.nombre as estado,e.numero_folio,pdemandante.demandante,pdemandado.demandado,delito.materia
        from expedientes e,ingresos ing,estados es,
        (select dp.idexpediente,group_concat(dp.apellido," ",dp.nombre SEPARATOR "; ")  as demandante
        from detalle_procesales dp, expedientes e,ingresos i
        where e.id=dp.idexpediente and i.id=e.idingreso and dp.idpprocesal=2 and i.numero_ingreso='."'".$numero."'".' and dp.condicion=1 group by dp.idexpediente) as pdemandante,
        (select dp.idexpediente,group_concat(dp.apellido," ",dp.nombre SEPARATOR "; ")  as demandado
        from detalle_procesales dp, expedientes e,ingresos i
        where e.id=dp.idexpediente and i.id=e.idingreso and dp.idpprocesal=1 and i.numero_ingreso='."'".$numero."'".' and dp.condicion=1 group by dp.idexpediente) as pdemandado,
        (select e.id as idexpediente,group_concat(m.nombre SEPARATOR ", ") as materia
        from materias m,detalle_materias dm, expedientes e,ingresos i
        where m.id=dm.idmateria and e.id=dm.idexpediente and i.id=e.idingreso and i.numero_ingreso='."'".$numero."'".' and dm.condicion=1 group by e.id) as delito
        cross join (select @i := 0) m
        where ing.id=e.idingreso and es.id=e.idestado and e.condicion=1 and e.verificado=1 and ing.numero_ingreso='."'".$numero."'".' 
        and pdemandante.idexpediente=e.id and pdemandado.idexpediente=e.id and delito.idexpediente=e.id';
        $consulta=DB::select($sql);
        $cabecera=DB::select('select UPPER(d.nombre) as distrito,UPPER(p.nombre) as provincia, UPPER(o.nombre) as organo,UPPER(i.nombre) as instancia,
        ing.numero_ingreso,now() as fecha
        from distrito_judiciales d,provincia_judiciales p,organo_judiciales o,instancia_judiciales i, ingresos ing
        where d.id=p.iddjudicial and p.id=o.idpjudicial and o.id=i.idojudicial and i.id=ing.idijudicial and ing.numero_ingreso='."'".$numero."'");
        
        $totalexpe=DB::select('select count(e.id) as cantidad1 from expedientes e,ingresos i where i.id=e.idingreso and e.condicion=1 and e.verificado=1 and i.numero_ingreso='."'".$numero."'");
        $folios=DB::select('select sum(e.numero_folio) as suma from expedientes e,ingresos i  where i.id=e.idingreso and e.condicion=1 and e.verificado=1 and i.numero_ingreso='."'".$numero."'");
        $AnaPaque=DB::select('select e.anaquel,e.paquete from expedientes e,ingresos i  where i.id=e.idingreso and e.condicion=1 and i.numero_ingreso='."'".$numero."'".' limit 1');
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
        foreach($totalexpe as $t){
            $texpedientes=$t->cantidad1;
            
        }
        foreach($folios as $f){
            $sumafolios=$f->suma;
            
        }
        for($m = 0; $m < $hojas; $m++){
            $conteo=$m+1;
            if($conteo==1){
                if($hojas>1){
                    for($j = 0; $j < $cantidad; $j++){
                        array_push($lista,$detalle[$j]);
                        
                    }
                    $n=$cantidad;
                    $nc=$n+$cantidad;//se define nueva cantidad a recorrer
                }else{
                    for($j = 0; $j < $c; $j++){
                        array_push($lista,$detalle[$j]);
                        
                    }
                    $n=$cantidad;
                    $nc=$n+$cantidad;//se define nueva cantidad a recorrer
                }
                
            }else{
                
                if($conteo<$hojas){
                    for($i = $n; $i < $nc; $i++){
                        array_push($lista,$detalle[$i]);
                       
                    }
                    $n=$nc;
                    $nc=$n+$cantidad;
                }else{
                    for($k = $n; $k < $c; $k++){
                        array_push($lista,$detalle[$k]);  
                       
                    }
                }
            }
            
            array_push($padre,[$lista,$hijo,($m+1),$hojas,$texpedientes,$sumafolios,$AnaPaque]);
            //limpiar array lista por cada iteracion
            $lista=[];

        }
        //dd($padre);
        $pdf= \PDF::loadView('pdf.ListadoExpedientespdf',
            ['padre'=>$padre])->setPaper('a4', 'landscape');
            return $pdf->stream('ListadoExpedientes.pdf',array("Attachment" => false));
       
    }
    public function reporteUbicacion(Request $request,$anaquel,$paquete){
        $anaquel=base64_decode($anaquel);
        $paquete=base64_decode($paquete);
        //$numero=$request->numero;
        
        $sql='SELECT @i := @i + 1 contador,e.idingreso,e.id as idexpediente,concat(e.numero_expediente,"-",e.anio_expediente,"-",if(e.idtexpediente=1,0,e.numero_cuaderno)) as expediente,
        es.nombre as estado,e.numero_folio,pdemandante.demandante,pdemandado.demandado,delito.materia
        from expedientes e,ingresos ing,estados es,
        (select dp.idexpediente,group_concat(dp.apellido," ",dp.nombre SEPARATOR "; ")  as demandante
        from detalle_procesales dp, expedientes e,ingresos i
        where e.id=dp.idexpediente and i.id=e.idingreso and dp.idpprocesal=2 and e.anaquel='.$anaquel.' and e.paquete='.$paquete.' and dp.condicion=1 group by dp.idexpediente) as pdemandante,
        (select dp.idexpediente,group_concat(dp.apellido," ",dp.nombre SEPARATOR "; ")  as demandado
        from detalle_procesales dp, expedientes e,ingresos i
        where e.id=dp.idexpediente and i.id=e.idingreso and dp.idpprocesal=1 and e.anaquel='.$anaquel.' and e.paquete='.$paquete.' and dp.condicion=1 group by dp.idexpediente) as pdemandado,
        (select e.id as idexpediente,group_concat(m.nombre SEPARATOR ", ") as materia
        from materias m,detalle_materias dm, expedientes e,ingresos i
        where m.id=dm.idmateria and e.id=dm.idexpediente and i.id=e.idingreso and e.anaquel='.$anaquel.' and e.paquete='.$paquete.' and dm.condicion=1 group by e.id) as delito
        cross join (select @i := 0) m
        where ing.id=e.idingreso and es.id=e.idestado and e.condicion=1 and e.verificado=1 and e.anaquel='.$anaquel.' and e.paquete='.$paquete.' 
        and pdemandante.idexpediente=e.id and pdemandado.idexpediente=e.id and delito.idexpediente=e.id';
        $consulta=DB::select($sql);
        $cabecera=DB::select('select UPPER(d.nombre) as distrito,UPPER(p.nombre) as provincia, UPPER(o.nombre) as organo,UPPER(i.nombre) as instancia,
        ing.numero_ingreso,now() as fecha
        from distrito_judiciales d,provincia_judiciales p,organo_judiciales o,instancia_judiciales i, ingresos ing,expedientes e
        where d.id=p.iddjudicial and p.id=o.idpjudicial and o.id=i.idojudicial and i.id=ing.idijudicial
        and ing.id=e.idingreso and e.anaquel='.$anaquel.' and paquete='.$paquete.' and e.condicion=1 and e.verificado=1 limit 1;');
        
        $totalexpe=DB::select('select count(e.id) as cantidad1 from expedientes e,ingresos i where i.id=e.idingreso and e.condicion=1 and e.verificado=1 and e.anaquel='.$anaquel.' and paquete='.$paquete);
        $folios=DB::select('select sum(e.numero_folio) as suma from expedientes e,ingresos i  where i.id=e.idingreso and e.condicion=1 and e.verificado=1 and e.anaquel='.$anaquel.' and paquete='.$paquete);
        $AnaPaque=DB::select('select e.anaquel,e.paquete from expedientes e,ingresos i  where i.id=e.idingreso and e.condicion=1 and e.anaquel='.$anaquel.' and paquete='.$paquete.' limit 1');
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
        foreach($totalexpe as $t){
            $texpedientes=$t->cantidad1;
            
        }
        foreach($folios as $f){
            $sumafolios=$f->suma;
            
        }
        for($m = 0; $m < $hojas; $m++){
            $conteo=$m+1;
            if($conteo==1){
                if($hojas>1){
                    for($j = 0; $j < $cantidad; $j++){
                        array_push($lista,$detalle[$j]);
                        
                    }
                    $n=$cantidad;
                    $nc=$n+$cantidad;//se define nueva cantidad a recorrer
                }else{
                    for($j = 0; $j < $c; $j++){
                        array_push($lista,$detalle[$j]);
                        
                    }
                    $n=$cantidad;
                    $nc=$n+$cantidad;//se define nueva cantidad a recorrer
                }
                
            }else{
                
                if($conteo<$hojas){
                    for($i = $n; $i < $nc; $i++){
                        array_push($lista,$detalle[$i]);
                        
                    }
                    $n=$nc;
                    $nc=$n+$cantidad;
                }else{
                    for($k = $n; $k < $c; $k++){
                        array_push($lista,$detalle[$k]);  
                       
                    }
                }
            }
            
            array_push($padre,[$lista,$hijo,($m+1),$hojas,$texpedientes,$sumafolios,$AnaPaque]);
            //limpiar array lista por cada iteracion
            $lista=[];

        }
        //dd($padre);
        $pdf= \PDF::loadView('pdf.ListadoExpedientespdf',
            ['padre'=>$padre])->setPaper('a4', 'landscape');
            return $pdf->stream('ListadoExpedientes.pdf',array("Attachment" => false));
       
    }
    //REPORTE PARA LISTA DE EXPEDEINTES POR PAQUETE SIN VERIFICAR
    public function reportePaquete1(Request $request,$numero){
        $numero=base64_decode($numero);
        //$numero=$request->numero;
        
        $sql='SELECT @i := @i + 1 contador,e.idingreso,e.id as idexpediente,concat(e.numero_expediente,"-",e.anio_expediente,"-",if(e.idtexpediente=1,0,e.numero_cuaderno)) as expediente,
        es.nombre as estado,e.numero_folio,pdemandante.demandante,pdemandado.demandado,delito.materia
        from expedientes e,ingresos ing,estados es,
        (select dp.idexpediente,group_concat(dp.apellido," ",dp.nombre SEPARATOR "; ")  as demandante
        from detalle_procesales dp, expedientes e,ingresos i
        where e.id=dp.idexpediente and i.id=e.idingreso and dp.idpprocesal=2 and i.numero_ingreso='."'".$numero."'".' and dp.condicion=1 group by dp.idexpediente) as pdemandante,
        (select dp.idexpediente,group_concat(dp.apellido," ",dp.nombre SEPARATOR "; ")  as demandado
        from detalle_procesales dp, expedientes e,ingresos i
        where e.id=dp.idexpediente and i.id=e.idingreso and dp.idpprocesal=1 and i.numero_ingreso='."'".$numero."'".' and dp.condicion=1 group by dp.idexpediente) as pdemandado,
        (select e.id as idexpediente,group_concat(m.nombre SEPARATOR ", ") as materia
        from materias m,detalle_materias dm, expedientes e,ingresos i
        where m.id=dm.idmateria and e.id=dm.idexpediente and i.id=e.idingreso and i.numero_ingreso='."'".$numero."'".' and dm.condicion=1 group by e.id) as delito
        cross join (select @i := 0) m
        where ing.id=e.idingreso and es.id=e.idestado and e.condicion=1 and e.verificado=0 and ing.numero_ingreso='."'".$numero."'".' 
        and pdemandante.idexpediente=e.id and pdemandado.idexpediente=e.id and delito.idexpediente=e.id';
        $consulta=DB::select($sql);
        $cabecera=DB::select('select UPPER(d.nombre) as distrito,UPPER(p.nombre) as provincia, UPPER(o.nombre) as organo,UPPER(i.nombre) as instancia,
        ing.numero_ingreso,now() as fecha
        from distrito_judiciales d,provincia_judiciales p,organo_judiciales o,instancia_judiciales i, ingresos ing
        where d.id=p.iddjudicial and p.id=o.idpjudicial and o.id=i.idojudicial and i.id=ing.idijudicial and ing.numero_ingreso='."'".$numero."'");
        
        $totalexpe=DB::select('select count(e.id) as cantidad1 from expedientes e,ingresos i where i.id=e.idingreso and e.condicion=1 and e.verificado=0 and i.numero_ingreso='."'".$numero."'");
        $folios=DB::select('select sum(e.numero_folio) as suma from expedientes e,ingresos i  where i.id=e.idingreso and e.condicion=1 and e.verificado=0 and i.numero_ingreso='."'".$numero."'");
        $AnaPaque=DB::select('select e.anaquel,e.paquete from expedientes e,ingresos i  where i.id=e.idingreso and e.condicion=1 and i.numero_ingreso='."'".$numero."'".' limit 1');
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
        foreach($totalexpe as $t){
            $texpedientes=$t->cantidad1;
            
        }
        foreach($folios as $f){
            $sumafolios=$f->suma;
            
        }
        for($m = 0; $m < $hojas; $m++){
            $conteo=$m+1;
            if($conteo==1){
                if($hojas>1){
                    for($j = 0; $j < $cantidad; $j++){
                        array_push($lista,$detalle[$j]);
                        
                    }
                    $n=$cantidad;
                    $nc=$n+$cantidad;//se define nueva cantidad a recorrer
                }else{
                    for($j = 0; $j < $c; $j++){
                        array_push($lista,$detalle[$j]);
                       
                    }
                    $n=$cantidad;
                    $nc=$n+$cantidad;//se define nueva cantidad a recorrer
                }
                
            }else{
                
                if($conteo<$hojas){
                    for($i = $n; $i < $nc; $i++){
                        array_push($lista,$detalle[$i]);
                        
                    }
                    $n=$nc;
                    $nc=$n+$cantidad;
                }else{
                    for($k = $n; $k < $c; $k++){
                        array_push($lista,$detalle[$k]);  
                       
                    }
                }
            }
            
            array_push($padre,[$lista,$hijo,($m+1),$hojas,$texpedientes,$sumafolios,$AnaPaque]);
            //limpiar array lista por cada iteracion
            $lista=[];

        }
        //dd($consulta);
        $pdf= \PDF::loadView('pdf.ListadoExpedientespdf',
            ['padre'=>$padre])->setPaper('a4', 'landscape');
            return $pdf->stream('ListadoExpedientes.pdf',array("Attachment" => false));
       
    }
    // REPORTE EN TEMPLATE DE INGRESOS POR FECHA
    public function consultaIngresoPorFecha(Request $request){
        if(!$request->ajax()) return redirect('/');
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;
        $usuario=$request->usuario;
        
        if($fecha_inicio==$fecha_fin){
            //dd('XD');
            $rpta=DB::select('SELECT @i := @i + 1 as contador,f.numero_ingreso,f.codigo,f.expediente,
            f.instancia,f.especialidad,f.tipoarchivo,
                        f.fecha_registro,f.nombre_local,f.anaquel,f.paquete
            FROM
            (SELECT t.numero_ingreso,t.codigo,t.expediente,t.instancia,t.especialidad,t.tipoarchivo,
                        t.fecha_registro,t.nombre_local,t.anaquel,t.paquete
                        FROM(
            select ing.numero_ingreso,e.codigo,concat(e.anio_expediente,"-",e.numero_expediente) as expediente,
            es.nombre as especialidad,i.nombre as instancia,t.nombre as tipoarchivo,
            date_format(date(e.created_at),"%d/%m/%Y") as fecha_registro,l.nombre as nombre_local,e.anaquel,e.paquete
            from ingresos ing,expedientes e,especialidades es,instancia_judiciales i,tipo_archivos t,locales l
            where i.id=ing.idijudicial and ing.id=e.idingreso and es.id=e.idespecialidad and t.id=e.idtarchivo
            and l.id=e.idlocal and e.verificado=1 and e.condicion=1 and ing.idusuario like '."'". $usuario ."'".'
            and date(e.created_at) ='."'".$fecha_inicio."'".' order by  date(e.created_at) asc) t
             order by t.numero_ingreso asc) f
             cross join (select @i := 0) m');
        }else{
            $rpta=DB::select('SELECT @i := @i + 1 as contador,f.numero_ingreso,f.codigo,f.expediente,
            f.instancia,f.especialidad,f.tipoarchivo,
                        f.fecha_registro,f.nombre_local,f.anaquel,f.paquete 
            FROM (SELECT t.numero_ingreso,t.codigo,t.expediente,t.instancia,t.especialidad,t.tipoarchivo, 
            t.fecha_registro,t.nombre_local,t.anaquel,t.paquete 
            FROM( select ing.numero_ingreso,e.codigo,concat(e.anio_expediente,"-",e.numero_expediente) as expediente, 
            es.nombre as especialidad,i.nombre as instancia,t.nombre as tipoarchivo, 
            date_format(date(e.created_at),"%d/%m/%Y") as fecha_registro,l.nombre as nombre_local,
            e.anaquel,e.paquete from ingresos ing,expedientes e,especialidades es,instancia_judiciales i,
            tipo_archivos t,locales l where i.id=ing.idijudicial and ing.id=e.idingreso 
            and es.id=e.idespecialidad and t.id=e.idtarchivo and l.id=e.idlocal and e.verificado=1 
            and e.condicion=1 and ing.idusuario like '."'". $usuario ."'".' and date(e.created_at) between '."'".$fecha_inicio."'".' and '."'".$fecha_fin."'".' 
            order by date(e.created_at) asc) t order by t.numero_ingreso asc) f 
            cross join (select @i := 0) m');
        }

        
        //dd($rpta);
        return ['consulta' =>$rpta];
    }

    public function getAllUsers(){
        $users=DB::select('select id, usuario from users');
        return ['usuarios' =>$users];
    }
    public function reporteIngresos(Request $request){
        // if(!$request->ajax()) return redirect('/reporte/ingresos');
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;
        $usuario=$request->usuario;
        
        if($fecha_inicio==$fecha_fin){
            
            $items=DB::select('SELECT @i := @i + 1 as contador,f.numero_ingreso,f.codigo,f.expediente,
            f.instancia,f.especialidad,f.tipoarchivo,
                        f.fecha_registro,f.nombre_local,f.anaquel,f.paquete
            FROM
            (SELECT t.numero_ingreso,t.codigo,t.expediente,t.instancia,t.especialidad,t.tipoarchivo,
                        t.fecha_registro,t.nombre_local,t.anaquel,t.paquete
                        FROM(
            select ing.numero_ingreso,e.codigo,concat(e.anio_expediente,"-",e.numero_expediente) as expediente,
            es.nombre as especialidad,i.nombre as instancia,t.nombre as tipoarchivo,
            date_format(date(e.created_at),"%d/%m/%Y") as fecha_registro,l.nombre as nombre_local,e.anaquel,e.paquete
            from ingresos ing,expedientes e,especialidades es,instancia_judiciales i,tipo_archivos t,locales l
            where i.id=ing.idijudicial and ing.id=e.idingreso and es.id=e.idespecialidad and t.id=e.idtarchivo
            and l.id=e.idlocal and e.verificado=1 and e.condicion=1 and ing.idusuario like '."'". $usuario ."'".'
            and date(e.created_at) ='."'".$fecha_inicio."'".' order by  date(e.created_at) asc) t
             order by t.numero_ingreso asc) f
             cross join (select @i := 0) m');
        }else{
            $items=DB::select('SELECT @i := @i + 1 as contador,f.numero_ingreso,f.codigo,f.expediente,
            f.instancia,f.especialidad,f.tipoarchivo,
                        f.fecha_registro,f.nombre_local,f.anaquel,f.paquete 
            FROM (SELECT t.numero_ingreso,t.codigo,t.expediente,t.instancia,t.especialidad,t.tipoarchivo, 
            t.fecha_registro,t.nombre_local,t.anaquel,t.paquete 
            FROM( select ing.numero_ingreso,e.codigo,concat(e.anio_expediente,"-",e.numero_expediente) as expediente, 
            es.nombre as especialidad,i.nombre as instancia,t.nombre as tipoarchivo, 
            date_format(date(e.created_at),"%d/%m/%Y") as fecha_registro,l.nombre as nombre_local,
            e.anaquel,e.paquete from ingresos ing,expedientes e,especialidades es,instancia_judiciales i,
            tipo_archivos t,locales l where i.id=ing.idijudicial and ing.id=e.idingreso 
            and es.id=e.idespecialidad and t.id=e.idtarchivo and l.id=e.idlocal and e.verificado=1 
            and e.condicion=1 and ing.idusuario like '."'". $usuario ."'".' and date(e.created_at) between '."'".$fecha_inicio."'".' and '."'".$fecha_fin."'".' 
            order by date(e.created_at) asc) t order by t.numero_ingreso asc) f 
            cross join (select @i := 0) m');
        }

        $pdf = PDF::loadView('pdf.reporteIngresos', compact('items'));
        $pdf->setPaper('A4', 'landscape');;
        return $pdf->stream();
    }
        // obtener total de consulta anterior
    public function totalIngresoPorFecha(Request $request){
        if(!$request->ajax()) return redirect('/');
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;
        if($fecha_inicio==$fecha_fin){
            $consultas= Expediente::join('ingresos','expedientes.idingreso','=','ingresos.id')
                ->join('especialidades','expedientes.idespecialidad','=','especialidades.id')
                ->join('tipo_expedientes','expedientes.idtexpediente','=','tipo_expedientes.id')
                ->join('estados','expedientes.idestado','=','estados.id')
                ->join('tipo_archivos','expedientes.idtarchivo','=','tipo_archivos.id')
                ->join('tipo_conclusiones','expedientes.idtconclusion','=','tipo_conclusiones.id')
                ->join('locales','expedientes.idlocal','=','locales.id')
                ->join('users','expedientes.idusuario','=','users.id')
                ->join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->select(
                DB::raw('count(expedientes.id) as total'))
                ->whereDate('expedientes.created_at','=',$fecha_inicio)
                ->where('expedientes.verificado','=','1')
                ->where('expedientes.condicion','=','1')->get();
        }else{
            $consultas= Expediente::join('ingresos','expedientes.idingreso','=','ingresos.id')
                ->join('especialidades','expedientes.idespecialidad','=','especialidades.id')
                ->join('tipo_expedientes','expedientes.idtexpediente','=','tipo_expedientes.id')
                ->join('estados','expedientes.idestado','=','estados.id')
                ->join('tipo_archivos','expedientes.idtarchivo','=','tipo_archivos.id')
                ->join('tipo_conclusiones','expedientes.idtconclusion','=','tipo_conclusiones.id')
                ->join('locales','expedientes.idlocal','=','locales.id')
                ->join('users','expedientes.idusuario','=','users.id')
                ->join('instancia_judiciales','ingresos.idijudicial','=','instancia_judiciales.id')
                ->select(
                DB::raw('count(expedientes.id) as total'))
                ->whereBetween('expedientes.created_at', [$fecha_inicio, $fecha_fin])
                ->where('expedientes.verificado','=','1')
                ->where('expedientes.condicion','=','1')->get();
        }
        

                return ['consultas' =>$consultas];
    
    }
    public function consultaIngresoPorFechaResumen(Request $request){
        if(!$request->ajax()) return redirect('/');
        $fecha_inicio=$request->fecha_inicio;
        $fecha_fin=$request->fecha_fin;
        
        if($fecha_inicio==$fecha_fin){
            //dd('XD');
            $rpta=DB::select('SELECT @i := @i + 1 as contador,numero_ingreso,total
            FROM(
            select ing.numero_ingreso,count(e.id) as total
            from ingresos ing,expedientes e,especialidades es,instancia_judiciales i,tipo_archivos t,locales l
            where i.id=ing.idijudicial and ing.id=e.idingreso and es.id=e.idespecialidad and t.id=e.idtarchivo
            and l.id=e.idlocal and e.verificado=1 and e.condicion=1 
            and date(e.created_at) ='."'".$fecha_inicio."'".' group by  ing.numero_ingreso order by ing.numero_ingreso asc) t
            cross join (select @i := 0) m;');
        }else{
            $rpta=DB::select('SELECT @i := @i + 1 as contador,numero_ingreso,total
            FROM(
            select ing.numero_ingreso,count(e.id) as total
            from ingresos ing,expedientes e,especialidades es,instancia_judiciales i,tipo_archivos t,locales l
            where i.id=ing.idijudicial and ing.id=e.idingreso and es.id=e.idespecialidad and t.id=e.idtarchivo
            and l.id=e.idlocal and e.verificado=1 and e.condicion=1 
            and date(e.created_at) between '."'".$fecha_inicio."'".' and '."'".$fecha_fin."'".' group by  ing.numero_ingreso order by ing.numero_ingreso asc) t
            cross join (select @i := 0) m;');
        }

        
        //dd($rpta);
        return ['consulta' =>$rpta];
    }
}
