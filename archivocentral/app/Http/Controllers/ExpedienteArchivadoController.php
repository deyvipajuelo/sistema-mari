<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExpedienteArchivado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ExpedienteArchivadoController extends Controller
{
    public function index(Request $request){
        if(!$request->ajax()) return redirect('/');
        $buscar=$request->buscar;
        $criterio=$request->criterio;
        $consulta= DB::select('SELECT ed.id as idedesarchivado ,e.idingreso,e.id as idexpediente,e.codigo, concat(e.anio_expediente,"-",e.numero_expediente) as expediente,ed.created_at,
        te.nombre as tipoexpediente,i.nombre as instancia,ing.numero_ingreso,e.idestado,ed.motivo,ed.id as idedesarchivado,
        l.nombre as direccion,e.anaquel,e.paquete,es.nombre as estado,pprocesales.id,pprocesales.parteprocesal,e.condicion
        from expedientes e,ingresos ing, instancia_judiciales i,locales l,estados es,tipo_expedientes te,expediente_desarchivados ed,
        (select persona.id,concat(materia,"\n",persona) as parteprocesal  from
        (select e.id as id, group_concat(if(pp.nombre="Demandante", "DTE", "DDO"),": ",dp.apellido," ",dp.nombre SEPARATOR "\n")  as persona
        from parte_procesales pp,detalle_procesales dp, expedientes e,ingresos i
        where pp.id=dp.idpprocesal and e.id=dp.idexpediente and i.id=e.idingreso 
		and e.verificado=1 and e.idestado=2 and dp.condicion=1 group by e.id) as persona, 
        (select e.id,group_concat(m.nombre SEPARATOR ", ") as materia
        from materias m,detalle_materias dm, expedientes e,ingresos i
        where m.id=dm.idmateria and e.id=dm.idexpediente and i.id=e.idingreso and e.verificado=1 and e.idestado=2 
        and dm.condicion=1  group by e.id) as pprocesal
        where persona.id=pprocesal.id) as pprocesales
        where ing.id=e.idingreso and i.id=ing.idijudicial and l.id=e.idlocal and es.id=e.idestado and te.id=e.idtexpediente
        and e.id=ed.idexpediente and e.verificado=1 and ed.idestado=2 
        and pprocesales.id=e.id and e.'.$criterio.' like "%'.$buscar.'%" order by e.id desc;');
        return $consulta;
    }
    public function store(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro=new ExpedienteArchivado();
        $registro->idexpediente=$request->idexpediente;
        $registro->motivo=$request->motivo;
        $registro->idestado=$request->idestado;
        $registro->idusuario=Auth::id();
        $registro->condicion='1';
        $registro->save();
    }
    public function update(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $registro= ExpedienteArchivado::findOrFail($request->id);
        $registro->idestado=1;
        $registro->condicion='1';
        $registro->save();
    } 
}
