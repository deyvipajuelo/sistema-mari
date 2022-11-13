<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SedeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\TipopersonalController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\InstanciaController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\EstadoController;
use App\Http\Controllers\TipoExpedienteController;
use App\Http\Controllers\TipoArchivoController;
use App\Http\Controllers\TipoConclusionController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\DistritoJudicialController;
use App\Http\Controllers\ProvinciaJudicialController;
use App\Http\Controllers\LocalJudicialController;
use App\Http\Controllers\OrganoJudicialController;
use App\Http\Controllers\InstanciaJudicialController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\ClasePersonaController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\ParteProcesalController;
use App\Http\Controllers\UbicacionPaqueteController;
use App\Http\Controllers\PaqueteVerificadoController;
use App\Http\Controllers\BuscarController;
use App\Http\Controllers\LegajoController;
use App\Http\Controllers\ExpedienteArchivadoController;


Route::group(['middleware'=>['guest']],function(){
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login1');
    Route::post('/login', [LoginController::class, 'login'])->name('login'); 
});



Route::group(['middleware'=>['auth']],function(){
    Route::post('/logout',[LoginController::class, 'logout'])->name('logout');

    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware'=>['administradorsistema']],function(){
    
        Route::get('/sede', [SedeController::class, 'index']);
        Route::post('/sede/registrar',[SedeController::class, 'store']);
        Route::put('/sede/actualizar',[SedeController::class, 'update']);
        Route::put('/sede/desactivar',[SedeController::class, 'desactivar']);
        Route::put('/sede/activar',[SedeController::class, 'activar']);
        Route::get('/sede/selectSede', [SedeController::class, 'selectSede']);
    
        Route::get('/perfil', [PerfilController::class, 'index']);
        Route::post('/perfil/registrar',[PerfilController::class, 'store']);
        Route::put('/perfil/actualizar',[PerfilController::class, 'update']);
        Route::put('/perfil/desactivar',[PerfilController::class, 'desactivar']);
        Route::put('/perfil/activar',[PerfilController::class, 'activar']);
        Route::get('/perfil/selectPerfil', [PerfilController::class, 'selectPerfil']);
    
        Route::get('/tipopersonal', [TipopersonalController::class, 'index']);
        Route::post('/tipopersonal/registrar',[TipopersonalController::class, 'store']);
        Route::put('/tipopersonal/actualizar',[TipopersonalController::class, 'update']);
        Route::put('/tipopersonal/desactivar',[TipopersonalController::class, 'desactivar']);
        Route::put('/tipopersonal/activar',[TipopersonalController::class, 'activar']);
        Route::get('/tipopersonal/selectTipopersonal', [TipopersonalController::class, 'selectTipopersonal']);
    
        Route::get('/personal', [PersonalController::class, 'index']);
        Route::post('/personal/registrar',[PersonalController::class, 'store']);
        Route::put('/personal/actualizar',[PersonalController::class, 'update']);
        Route::put('/personal/desactivar',[PersonalController::class, 'desactivar']);
        Route::put('/personal/activar',[PersonalController::class, 'activar']);
        Route::get('/personal/selectPersonal', [PersonalController::class, 'selectPersonal']);
        Route::get('/personal/comboPersonal', [PersonalController::class, 'comboPersonal']);
    
        Route::get('/area', [AreaController::class, 'index']);
        Route::post('/area/registrar',[AreaController::class, 'store']);
        Route::put('/area/actualizar',[AreaController::class, 'update']);
        Route::put('/area/desactivar',[AreaController::class, 'desactivar']);
        Route::put('/area/activar',[AreaController::class, 'activar']);
        Route::get('/area/selectArea', [AreaController::class, 'selectArea']);
    
        Route::get('/instancia', [InstanciaController::class, 'index']);
        Route::post('/instancia/registrar',[InstanciaController::class, 'store']);
        Route::put('/instancia/actualizar',[InstanciaController::class, 'update']);
        Route::put('/instancia/desactivar',[InstanciaController::class, 'desactivar']);
        Route::put('/instancia/activar',[InstanciaController::class, 'activar']);
        Route::get('/instancia/selectInstancia', [InstanciaController::class, 'selectInstancia']);
        Route::get('/instancia/comboInstancia', [InstanciaController::class, 'comboInstancia']);
    
        Route::get('/persona', [PersonaController::class, 'index']);
        Route::post('/persona/registrar',[PersonaController::class, 'store']);
        Route::post('/persona/actualizar',[PersonaController::class, 'update']);
        Route::put('/persona/desactivar',[PersonaController::class, 'desactivar']);
        Route::put('/persona/activar',[PersonaController::class, 'activar']);
        Route::get('/persona/selectPersona', [PersonaController::class, 'selectPersona']);
        Route::get('/persona/selectPersona1', [PersonaController::class, 'selectPersona1']);
        Route::get('/persona/selectPersonaArea', [PersonaController::class, 'selectPersonaArea']);
        Route::get('/persona/obtenerPersona', [PersonaController::class, 'obtenerPersona']);
        
    
        Route::get('/rol', [RolController::class, 'index']);
        Route::post('/rol/registrar',[RolController::class, 'store']);
        Route::put('/rol/actualizar',[RolController::class, 'update']);
        Route::put('/rol/desactivar',[RolController::class, 'desactivar']);
        Route::put('/rol/activar',[RolController::class, 'activar']);
        Route::get('/rol/selectRol', [RolController::class, 'selectRol']);
    
        Route::get('/user', [UserController::class, 'index']);
        Route::post('/user/registrar',[UserController::class, 'store']);
        Route::put('/user/actualizar',[UserController::class, 'update']);
        Route::put('/user/actualizarPassword',[UserController::class, 'actualizarPassword']);
        Route::put('/user/desactivar',[UserController::class, 'desactivar']);
        Route::put('/user/activar',[UserController::class, 'activar']);
        Route::get('/user/obtenerPersona/', [UserController::class, 'obtenerPersona']);
        
        Route::get('/estado', [EstadoController::class, 'index']);
        Route::post('/estado/registrar',[EstadoController::class, 'store']);
        Route::put('/estado/actualizar',[EstadoController::class, 'update']);
        Route::put('/estado/desactivar',[EstadoController::class, 'desactivar']);
        Route::put('/estado/activar',[EstadoController::class, 'activar']);
        Route::get('/estado/selectEstado', [EstadoController::class, 'selectEstado']);
    
        Route::get('/texpediente', [TipoExpedienteController::class, 'index']);
        Route::post('/texpediente/registrar',[TipoExpedienteController::class, 'store']);
        Route::put('/texpediente/actualizar',[TipoExpedienteController::class, 'update']);
        Route::put('/texpediente/desactivar',[TipoExpedienteController::class, 'desactivar']);
        Route::put('/texpediente/activar',[TipoExpedienteController::class, 'activar']);
        Route::get('/texpediente/selectTipoExpediente', [TipoExpedienteController::class, 'selectTipoExpediente']);
    
        Route::get('/tarchivo', [TipoArchivoController::class, 'index']);
        Route::post('/tarchivo/registrar',[TipoArchivoController::class, 'store']);
        Route::put('/tarchivo/actualizar',[TipoArchivoController::class, 'update']);
        Route::put('/tarchivo/desactivar',[TipoArchivoController::class, 'desactivar']);
        Route::put('/tarchivo/activar',[TipoArchivoController::class, 'activar']);
        Route::get('/tarchivo/selectTipoArchivo', [TipoArchivoController::class, 'selectTipoArchivo']);
    
        Route::get('/tconclusion', [TipoConclusionController::class, 'index']);
        Route::post('/tconclusion/registrar',[TipoConclusionController::class, 'store']);
        Route::put('/tconclusion/actualizar',[TipoConclusionController::class, 'update']);
        Route::put('/tconclusion/desactivar',[TipoConclusionController::class, 'desactivar']);
        Route::put('/tconclusion/activar',[TipoConclusionController::class, 'activar']);
        Route::get('/tconclusion/selectTipoConclusion', [TipoConclusionController::class, 'selectTipoConclusion']);
    
        Route::get('/especialidad', [EspecialidadController::class, 'index']);
        Route::post('/especialidad/registrar',[EspecialidadController::class, 'store']);
        Route::put('/especialidad/actualizar',[EspecialidadController::class, 'update']);
        Route::put('/especialidad/desactivar',[EspecialidadController::class, 'desactivar']);
        Route::put('/especialidad/activar',[EspecialidadController::class, 'activar']);
        Route::get('/especialidad/selectEspecialidad', [EspecialidadController::class, 'selectEspecialidad']);
    
        Route::get('/djudicial', [DistritoJudicialController::class, 'index']);
        Route::post('/djudicial/registrar',[DistritoJudicialController::class, 'store']);
        Route::put('/djudicial/actualizar',[DistritoJudicialController::class, 'update']);
        Route::put('/djudicial/desactivar',[DistritoJudicialController::class, 'desactivar']);
        Route::put('/djudicial/activar',[DistritoJudicialController::class, 'activar']);
        Route::get('/djudicial/selectDistritoJudicial', [DistritoJudicialController::class, 'selectDistritoJudicial']);
    
        Route::get('/pjudicial', [ProvinciaJudicialController::class, 'index']);
        Route::post('/pjudicial/registrar',[ProvinciaJudicialController::class, 'store']);
        Route::put('/pjudicial/actualizar',[ProvinciaJudicialController::class, 'update']);
        Route::put('/pjudicial/desactivar',[ProvinciaJudicialController::class, 'desactivar']);
        Route::put('/pjudicial/activar',[ProvinciaJudicialController::class, 'activar']);
        Route::get('/pjudicial/selectProvinciaJudicial', [ProvinciaJudicialController::class, 'selectProvinciaJudicial']);
        Route::get('/pjudicial/comboProvinciaJudicial', [ProvinciaJudicialController::class, 'comboProvinciaJudicial']);
    
        Route::get('/ljudicial', [LocalJudicialController::class, 'index']);
        Route::post('/ljudicial/registrar',[LocalJudicialController::class, 'store']);
        Route::put('/ljudicial/actualizar',[LocalJudicialController::class, 'update']);
        Route::put('/ljudicial/desactivar',[LocalJudicialController::class, 'desactivar']);
        Route::put('/ljudicial/activar',[LocalJudicialController::class, 'activar']);
        Route::get('/ljudicial/selectLocalJudicial', [LocalJudicialController::class, 'selectLocalJudicial']);
        Route::get('/ljudicial/comboLocalJudicial', [LocalJudicialController::class, 'comboLocalJudicial']);
    
        Route::get('/ojudicial', [OrganoJudicialController::class, 'index']);
        Route::post('/ojudicial/registrar',[OrganoJudicialController::class, 'store']);
        Route::put('/ojudicial/actualizar',[OrganoJudicialController::class, 'update']);
        Route::put('/ojudicial/desactivar',[OrganoJudicialController::class, 'desactivar']);
        Route::put('/ojudicial/activar',[OrganoJudicialController::class, 'activar']);
        Route::get('/ojudicial/selectOrganoJudicial', [OrganoJudicialController::class, 'selectOrganoJudicial']);
        Route::get('/ojudicial/comboOrganoJudicial', [OrganoJudicialController::class, 'comboOrganoJudicial']);
    
        Route::get('/ijudicial', [InstanciaJudicialController::class, 'index']);
        Route::post('/ijudicial/registrar',[InstanciaJudicialController::class, 'store']);
        Route::put('/ijudicial/actualizar',[InstanciaJudicialController::class, 'update']);
        Route::put('/ijudicial/desactivar',[InstanciaJudicialController::class, 'desactivar']);
        Route::put('/ijudicial/activar',[InstanciaJudicialController::class, 'activar']);
        Route::get('/ijudicial/selectInstanciaJudicial', [InstanciaJudicialController::class, 'selectInstanciaJudicial']);
        Route::get('/ijudicial/comboInstanciaJudicial', [InstanciaJudicialController::class, 'comboInstanciaJudicial']);
        Route::get('/ijudicial/obtenerProcedencia', [InstanciaJudicialController::class, 'obtenerProcedencia']);
    
        Route::get('/local', [LocalController::class, 'index']);
        Route::post('/local/registrar',[LocalController::class, 'store']);
        Route::put('/local/actualizar',[LocalController::class, 'update']);
        Route::put('/local/desactivar',[LocalController::class, 'desactivar']);
        Route::put('/local/activar',[LocalController::class, 'activar']);
        Route::get('/local/selectLocal', [LocalController::class, 'selectLocal']);
    
        Route::get('/ingreso', [IngresoController::class, 'index']);
        Route::get('/ingreso/obtenerTotal', [IngresoController::class, 'obtenerTotal']);
        Route::get('/ingreso/obtenerCodigo', [IngresoController::class, 'obtenerCodigo']);
        Route::post('/ingreso/registrar',[IngresoController::class, 'store']);
        Route::put('/ingreso/actualizar',[IngresoController::class, 'update']);
        Route::get('/ingreso/obtenerTotalNumero', [IngresoController::class, 'obtenerTotalNumero']);
        Route::get('/ingreso/obtenerId', [IngresoController::class, 'obtenerId']);
        Route::get('/ingreso/obtenerProcedencia', [IngresoController::class, 'obtenerProcedencia']);
        Route::get('/ingreso/obtenerCantidadExpediente', [IngresoController::class, 'obtenerCantidadExpediente']);
        Route::put('/ingreso/actualizarRegistro',[IngresoController::class, 'actualizarRegistro']);
        Route::get('/ingreso/obtenerTotalVerificado', [IngresoController::class, 'obtenerTotalVerificado']);
        Route::get('/ingreso/obtenerTotal1', [IngresoController::class, 'obtenerTotal1']);
        Route::get('/ingreso/obtenerTotal2', [IngresoController::class, 'obtenerTotal2']);
        Route::put('/ingreso/desactivar',[IngresoController::class, 'desactivar']);
        Route::put('/ingreso/activar',[IngresoController::class, 'activar']);
        Route::get('/ingreso/lista', [IngresoController::class, 'listado']);
        Route::put('/ingreso/actualizarCantidadExpediente',[IngresoController::class, 'actualizarCantidadExpediente']);
    
        Route::get('/expediente', [ExpedienteController::class, 'index']);
        Route::post('/expediente/registrar',[ExpedienteController::class, 'store']);
        Route::get('/expediente/obtenerCabecera', [ExpedienteController::class, 'obtenerCabecera']);
        Route::get('/expediente/obtenerDetalle1', [ExpedienteController::class, 'obtenerDetalle1']);
        Route::get('/expediente/obtenerDetalle2', [ExpedienteController::class, 'obtenerDetalle2']);
        Route::put('/expediente/actualizar',[ExpedienteController::class, 'update']);
        Route::post('/expediente/registrarDetalle',[ExpedienteController::class, 'registrarDetalle']);
        Route::post('/expediente/registrarDetalle1',[ExpedienteController::class, 'registrarDetalle1']);
        Route::put('/expediente/activarDetalle',[ExpedienteController::class, 'activarDetalle']);
        Route::put('/expediente/activarDetalle1',[ExpedienteController::class, 'activarDetalle1']);
        Route::put('/expediente/desactivarDetalle',[ExpedienteController::class, 'desactivarDetalle']);
        Route::put('/expediente/desactivarDetalle1',[ExpedienteController::class, 'desactivarDetalle1']);
        Route::put('/expediente/activarRegistro',[ExpedienteController::class, 'activarRegistro']);
        Route::put('/expediente/desactivarRegistro',[ExpedienteController::class, 'desactivarRegistro']);
        Route::post('/expediente/registrarAnulado',[ExpedienteController::class, 'registrarAnulado']);
        Route::get('/expediente/obtenerEstado', [ExpedienteController::class, 'obtenerEstado']);
        Route::get('/expediente/obtenerExpedienteIngresado', [ExpedienteController::class, 'obtenerExpedienteIngresado']);
        Route::get('/expediente/obtenerExpedienteVerificado', [ExpedienteController::class, 'obtenerExpedienteVerificado']);
        Route::get('/expediente/obtenerExpedienteSinVerificar', [ExpedienteController::class, 'obtenerExpedienteSinVerificar']);
        Route::put('/expediente/actualizarRegistro',[ExpedienteController::class, 'actualizarRegistro']);
        Route::put('/expediente/actualizarRegistro1',[ExpedienteController::class, 'actualizarRegistro1']);
        Route::put('/expediente/actualizarRegistro2',[ExpedienteController::class, 'actualizarRegistro2']);
        Route::put('/expediente/actualizar1',[ExpedienteController::class, 'actualizar1']);
        Route::get('/expediente/obtenerTotalPaqueteUbicado', [ExpedienteController::class, 'obtenerTotalPaqueteUbicado']);
        Route::get('/expediente/obtenerTotalPaqueteVerificado', [ExpedienteController::class, 'obtenerTotalPaqueteVerificado']);
        Route::get('/expediente/obtenerTotal', [ExpedienteController::class, 'obtenerTotal']);
        Route::get('/expediente/obtenerTotal1', [ExpedienteController::class, 'obtenerTotal1']);
        Route::get('/expediente/obtenerTotalId', [ExpedienteController::class, 'obtenerTotalId']);
        Route::get('/expediente/lista', [ExpedienteController::class, 'lista']);
        Route::get('/expediente/expedienteConFiltro', [ExpedienteController::class, 'expedienteConFiltro']);
        Route::get('/expediente/expedienteGeneral', [ExpedienteController::class, 'expedienteGeneral']);
        Route::post('/expediente/registrarOdecma',[ExpedienteController::class, 'registrarOdecma']);
        Route::put('/expediente/actualizarOdecma',[ExpedienteController::class, 'actualizarOdecma']);
        Route::put('/expediente/empaquetarExpediente',[ExpedienteController::class, 'empaquetarExpediente']);
    
        Route::get('/cpersona', [ClasePersonaController::class, 'index']);
        Route::post('/cpersona/registrar',[ClasePersonaController::class, 'store']);
        Route::put('/cpersona/actualizar',[ClasePersonaController::class, 'update']);
        Route::put('/cpersona/desactivar',[ClasePersonaController::class, 'desactivar']);
        Route::put('/cpersona/activar',[ClasePersonaController::class, 'activar']);
        Route::get('/cpersona/selectClasePersona', [ClasePersonaController::class, 'selectClasePersona']);
        Route::get('/cpersona/obtenerNombre', [ClasePersonaController::class, 'obtenerNombre']);
    
        Route::get('/materia', [MateriaController::class, 'index']);
        Route::post('/materia/registrar',[MateriaController::class, 'store']);
        Route::put('/materia/actualizar',[MateriaController::class, 'update']);
        Route::put('/materia/desactivar',[MateriaController::class, 'desactivar']);
        Route::put('/materia/activar',[MateriaController::class, 'activar']);
        Route::get('/materia/selectMateria', [MateriaController::class, 'selectMateria']);
        Route::get('/materia/obtenerNombre', [MateriaController::class, 'obtenerNombre']);
        
        Route::get('/pprocesal', [ParteProcesalController::class, 'index']);
        Route::post('/pprocesal/registrar',[ParteProcesalController::class, 'store']);
        Route::put('/pprocesal/actualizar',[ParteProcesalController::class, 'update']);
        Route::put('/pprocesal/desactivar',[ParteProcesalController::class, 'desactivar']);
        Route::put('/pprocesal/activar',[ParteProcesalController::class, 'activar']);
        Route::get('/pprocesal/selectParteProcesal', [ParteProcesalController::class, 'selectParteProcesal']);
        Route::get('/pprocesal/obtenerNombre', [ParteProcesalController::class, 'obtenerNombre']);
    
        Route::post('/upaquete/registrar',[UbicacionPaqueteController::class, 'store']);
    
        Route::post('/pverificado/registrar',[PaqueteVerificadoController::class, 'store']);
        Route::get('/pverificado/obtenerTotal',[PaqueteVerificadoController::class, 'obtenerTotal']);
        Route::get('/pverificado/obtenerSumaVerificado',[PaqueteVerificadoController::class, 'obtenerSumaVerificado']);
        Route::put('/pverificado/actualizar',[PaqueteVerificadoController::class, 'update']);
    
        Route::get('/consulta/consultaPaquete',[BuscarController::class, 'consultaPaquete']);
        Route::get('/consulta/consultaExpediente',[BuscarController::class, 'consultaExpediente']);
        Route::get('/consulta/consultaParteProcesal',[BuscarController::class, 'consultaParteProcesal']);
        Route::get('/consulta/consultaAnaquel',[BuscarController::class, 'consultaAnaquel']);
        Route::get('/reporte/paquete/{numero}',[BuscarController::class, 'reportePaquete']);
        Route::get('/reporte/paquete/sinVerificar/{numero}',[BuscarController::class, 'reportePaquete1']);
        Route::get('/consulta/ingresoPorFecha',[BuscarController::class, 'consultaIngresoPorFecha']);
        Route::get('/consulta/totalIngresoPorFecha',[BuscarController::class, 'totalIngresoPorFecha']);
        Route::get('/consulta/ingresoPorFechaResumen',[BuscarController::class, 'consultaIngresoPorFechaResumen']);
        Route::get('/reporte/ubicacion/{anaquel}/{paquete}',[BuscarController::class, 'reporteUbicacion']);

        Route::get('/legajo',[LegajoController::class, 'index']);
        Route::post('/legajo/registrar',[LegajoController::class, 'store']);
        Route::put('/legajo/desactivar',[LegajoController::class, 'desactivar']);
        Route::put('/legajo/activar',[LegajoController::class, 'activar']);
        Route::get('/legajo/obtenerCabecera', [LegajoController::class, 'obtenerCabecera']);
        Route::get('/legajo/obtenerDetalle1', [LegajoController::class, 'obtenerDetalle1']);
        Route::put('/legajo/actualizar',[LegajoController::class, 'update']);
        Route::post('/legajo/registrarDetalle',[LegajoController::class, 'registrarDetalle']);
        Route::put('/legajo/activarDetalle',[LegajoController::class, 'activarDetalle']);
        Route::put('/legajo/desactivarDetalle',[LegajoController::class, 'desactivarDetalle']);
        Route::get('/legajo/reporte/{id}', [LegajoController::class, 'reporte']);
        Route::get('/legajo/obtenerTotal', [LegajoController::class, 'obtenerTotal']);

        Route::get('/desarchivar',[ExpedienteArchivadoController::class, 'index']);
        Route::post('/desarchivar/registrar',[ExpedienteArchivadoController::class, 'store']);
        Route::put('/desarchivar/actualizar',[ExpedienteArchivadoController::class, 'update']);
        Route::get('/desarchivar/obtenerTotal', [ExpedienteArchivadoController::class, 'obtenerTotal']);
    
    });
    Route::put('/user/actualizarPassword',[UserController::class, 'actualizarPassword']);
            
    Route::get('/user/obtenerPersona/', [UserController::class, 'obtenerPersona']);
    
    Route::get('/estado/selectEstado', [EstadoController::class, 'selectEstado']);

    Route::get('/texpediente/selectTipoExpediente', [TipoExpedienteController::class, 'selectTipoExpediente']);

    Route::get('/tarchivo/selectTipoArchivo', [TipoArchivoController::class, 'selectTipoArchivo']);

    Route::get('/tconclusion/selectTipoConclusion', [TipoConclusionController::class, 'selectTipoConclusion']);

    Route::get('/especialidad/selectEspecialidad', [EspecialidadController::class, 'selectEspecialidad']);

    Route::get('/djudicial/selectDistritoJudicial', [DistritoJudicialController::class, 'selectDistritoJudicial']);

    Route::get('/pjudicial/selectProvinciaJudicial', [ProvinciaJudicialController::class, 'selectProvinciaJudicial']);
    Route::get('/pjudicial/comboProvinciaJudicial', [ProvinciaJudicialController::class, 'comboProvinciaJudicial']);

    Route::get('/ljudicial/selectLocalJudicial', [LocalJudicialController::class, 'selectLocalJudicial']);
    Route::get('/ljudicial/comboLocalJudicial', [LocalJudicialController::class, 'comboLocalJudicial']);

    Route::get('/ojudicial/selectOrganoJudicial', [OrganoJudicialController::class, 'selectOrganoJudicial']);
    Route::get('/ojudicial/comboOrganoJudicial', [OrganoJudicialController::class, 'comboOrganoJudicial']);

    Route::get('/ijudicial/selectInstanciaJudicial', [InstanciaJudicialController::class, 'selectInstanciaJudicial']);
    Route::get('/ijudicial/comboInstanciaJudicial', [InstanciaJudicialController::class, 'comboInstanciaJudicial']);
    Route::get('/ijudicial/obtenerProcedencia', [InstanciaJudicialController::class, 'obtenerProcedencia']);

    Route::get('/local/selectLocal', [LocalController::class, 'selectLocal']);

    Route::get('/ingreso', [IngresoController::class, 'index']);
    Route::get('/ingreso/obtenerTotal', [IngresoController::class, 'obtenerTotal']);
    Route::get('/ingreso/obtenerCodigo', [IngresoController::class, 'obtenerCodigo']);
    Route::post('/ingreso/registrar',[IngresoController::class, 'store']);
    Route::put('/ingreso/actualizar',[IngresoController::class, 'update']);
    Route::get('/ingreso/obtenerTotalNumero', [IngresoController::class, 'obtenerTotalNumero']);
    Route::get('/ingreso/obtenerId', [IngresoController::class, 'obtenerId']);
    Route::get('/ingreso/obtenerProcedencia', [IngresoController::class, 'obtenerProcedencia']);
    Route::get('/ingreso/obtenerCantidadExpediente', [IngresoController::class, 'obtenerCantidadExpediente']);
    Route::put('/ingreso/actualizarRegistro',[IngresoController::class, 'actualizarRegistro']);
    Route::get('/ingreso/obtenerTotalVerificado', [IngresoController::class, 'obtenerTotalVerificado']);
    Route::get('/ingreso/obtenerTotal1', [IngresoController::class, 'obtenerTotal1']);
    Route::get('/ingreso/obtenerTotal2', [IngresoController::class, 'obtenerTotal2']);
    Route::put('/ingreso/desactivar',[IngresoController::class, 'desactivar']);
    Route::put('/ingreso/activar',[IngresoController::class, 'activar']);
    Route::get('/ingreso/lista', [IngresoController::class, 'listado']);
    Route::put('/ingreso/actualizarCantidadExpediente',[IngresoController::class, 'actualizarCantidadExpediente']);

    Route::get('/expediente', [ExpedienteController::class, 'index']);
    Route::post('/expediente/registrar',[ExpedienteController::class, 'store']);
    Route::get('/expediente/obtenerCabecera', [ExpedienteController::class, 'obtenerCabecera']);
    Route::get('/expediente/obtenerDetalle1', [ExpedienteController::class, 'obtenerDetalle1']);
    Route::get('/expediente/obtenerDetalle2', [ExpedienteController::class, 'obtenerDetalle2']);
    Route::put('/expediente/actualizar',[ExpedienteController::class, 'update']);
    Route::post('/expediente/registrarDetalle',[ExpedienteController::class, 'registrarDetalle']);
    Route::post('/expediente/registrarDetalle1',[ExpedienteController::class, 'registrarDetalle1']);
    Route::put('/expediente/activarDetalle',[ExpedienteController::class, 'activarDetalle']);
    Route::put('/expediente/activarDetalle1',[ExpedienteController::class, 'activarDetalle1']);
    Route::put('/expediente/desactivarDetalle',[ExpedienteController::class, 'desactivarDetalle']);
    Route::put('/expediente/desactivarDetalle1',[ExpedienteController::class, 'desactivarDetalle1']);
    Route::put('/expediente/activarRegistro',[ExpedienteController::class, 'activarRegistro']);
    Route::put('/expediente/desactivarRegistro',[ExpedienteController::class, 'desactivarRegistro']);
    Route::post('/expediente/registrarAnulado',[ExpedienteController::class, 'registrarAnulado']);
    Route::get('/expediente/obtenerEstado', [ExpedienteController::class, 'obtenerEstado']);
    Route::get('/expediente/obtenerExpedienteIngresado', [ExpedienteController::class, 'obtenerExpedienteIngresado']);
    Route::get('/expediente/obtenerExpedienteVerificado', [ExpedienteController::class, 'obtenerExpedienteVerificado']);
    Route::get('/expediente/obtenerExpedienteSinVerificar', [ExpedienteController::class, 'obtenerExpedienteSinVerificar']);
    Route::put('/expediente/actualizarRegistro',[ExpedienteController::class, 'actualizarRegistro']);
    Route::put('/expediente/actualizarRegistro1',[ExpedienteController::class, 'actualizarRegistro1']);
    Route::put('/expediente/actualizarRegistro2',[ExpedienteController::class, 'actualizarRegistro2']);
    Route::put('/expediente/actualizar1',[ExpedienteController::class, 'actualizar1']);
    Route::get('/expediente/obtenerTotalPaqueteUbicado', [ExpedienteController::class, 'obtenerTotalPaqueteUbicado']);
    Route::get('/expediente/obtenerTotalPaqueteVerificado', [ExpedienteController::class, 'obtenerTotalPaqueteVerificado']);
    Route::get('/expediente/obtenerTotal', [ExpedienteController::class, 'obtenerTotal']);
    Route::get('/expediente/obtenerTotal1', [ExpedienteController::class, 'obtenerTotal1']);
    Route::get('/expediente/obtenerTotalId', [ExpedienteController::class, 'obtenerTotalId']);
    Route::get('/expediente/lista', [ExpedienteController::class, 'lista']);
    Route::get('/expediente/expedienteConFiltro', [ExpedienteController::class, 'expedienteConFiltro']);
    Route::get('/expediente/expedienteGeneral', [ExpedienteController::class, 'expedienteGeneral']);
    Route::post('/expediente/registrarOdecma',[ExpedienteController::class, 'registrarOdecma']);
    Route::put('/expediente/actualizarOdecma',[ExpedienteController::class, 'actualizarOdecma']);
    Route::put('/expediente/empaquetarExpediente',[ExpedienteController::class, 'empaquetarExpediente']);

    Route::get('/cpersona/selectClasePersona', [ClasePersonaController::class, 'selectClasePersona']);
    Route::get('/cpersona/obtenerNombre', [ClasePersonaController::class, 'obtenerNombre']);

    Route::get('/materia/selectMateria', [MateriaController::class, 'selectMateria']);
    Route::get('/materia/obtenerNombre', [MateriaController::class, 'obtenerNombre']);
    
    Route::get('/pprocesal/selectParteProcesal', [ParteProcesalController::class, 'selectParteProcesal']);
    Route::get('/pprocesal/obtenerNombre', [ParteProcesalController::class, 'obtenerNombre']);

    Route::post('/upaquete/registrar',[UbicacionPaqueteController::class, 'store']);

    Route::post('/pverificado/registrar',[PaqueteVerificadoController::class, 'store']);
    Route::get('/pverificado/obtenerTotal',[PaqueteVerificadoController::class, 'obtenerTotal']);
    Route::get('/pverificado/obtenerSumaVerificado',[PaqueteVerificadoController::class, 'obtenerSumaVerificado']);
    Route::put('/pverificado/actualizar',[PaqueteVerificadoController::class, 'update']);

    Route::get('/consulta/consultaPaquete',[BuscarController::class, 'consultaPaquete']);
    Route::get('/consulta/consultaExpediente',[BuscarController::class, 'consultaExpediente']);
    Route::get('/consulta/consultaParteProcesal',[BuscarController::class, 'consultaParteProcesal']);
    Route::get('/consulta/consultaAnaquel',[BuscarController::class, 'consultaAnaquel']);
    Route::get('/reporte/paquete/{numero}',[BuscarController::class, 'reportePaquete']);
    Route::get('/reporte/paquete/sinVerificar/{numero}',[BuscarController::class, 'reportePaquete1']);
    Route::get('/consulta/ingresoPorFecha',[BuscarController::class, 'consultaIngresoPorFecha']);
    Route::get('/consulta/totalIngresoPorFecha',[BuscarController::class, 'totalIngresoPorFecha']);
    Route::get('/consulta/ingresoPorFechaResumen',[BuscarController::class, 'consultaIngresoPorFechaResumen']);
    Route::get('/reporte/ubicacion/{anaquel}/{paquete}',[BuscarController::class, 'reporteUbicacion']);

    Route::get('/legajo',[LegajoController::class, 'index']);
    Route::post('/legajo/registrar',[LegajoController::class, 'store']);
    Route::put('/legajo/desactivar',[LegajoController::class, 'desactivar']);
    Route::put('/legajo/activar',[LegajoController::class, 'activar']);
    Route::get('/legajo/obtenerCabecera', [LegajoController::class, 'obtenerCabecera']);
    Route::get('/legajo/obtenerDetalle1', [LegajoController::class, 'obtenerDetalle1']);
    Route::put('/legajo/actualizar',[LegajoController::class, 'update']);
    Route::post('/legajo/registrarDetalle',[LegajoController::class, 'registrarDetalle']);
    Route::put('/legajo/activarDetalle',[LegajoController::class, 'activarDetalle']);
    Route::put('/legajo/desactivarDetalle',[LegajoController::class, 'desactivarDetalle']);
    Route::get('/legajo/reporte/{id}', [LegajoController::class, 'reporte']);
    Route::get('/legajo/obtenerTotal', [LegajoController::class, 'obtenerTotal']);

    Route::get('/desarchivar',[ExpedienteArchivadoController::class, 'index']);
    Route::post('/desarchivar/registrar',[ExpedienteArchivadoController::class, 'store']);
    Route::put('/desarchivar/actualizar',[ExpedienteArchivadoController::class, 'update']);

    

});
    
    

    

