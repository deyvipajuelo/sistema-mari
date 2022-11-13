<template>
   <section class="content">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
            
                <li class="breadcrumb-item"><a href="main">Inicio</a></li>
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    
                   <!-- LISTADO -->
                    <template v-if="listado==1">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Legajo
                        <button type="button"  class="btn btn-secondary" @click="registrarNuevo()">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="anaquel">Anaquel</option>
                                      <option value="paquete">Paquete</option>
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarConsulta(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarConsulta(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Distrito</th>
                                        <th>Provincia</th>
                                        <th>Instancia</th>
                                        <th>Asunto</th>
                                        
                                        <th>A</th>
                                        <th>P</th>
                                        <th>Condicion</th>
                                        
                                    </tr>
                                </thead>
                               <tbody v-if="arrayListado.length">
                                            <tr v-for="lista in arrayListado" :key="lista.id">
                                                <td>
                                                    <template v-if="lista.condicion">
                                                        <button type="button" @click="abrirActualizar(lista.id)" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-pencil"></i></button>
                                                        <button type="button" @click="reporte(lista.id)" class="btn btn-info btn-sm">
                                                        <i class="fa fa-file-pdf-o"></i>
                                                        </button>  
                                                         <button type="button" class="btn btn-danger btn-sm" @click="desactivarRegistro(lista.id)">
                                                        <i class="fa fa-trash"></i></button>
                                                    </template>
                                                    <template v-else>
                                                        <button type="button" class="btn btn-success btn-sm" @click="activarRegistro(lista.id)">
                                                        <i class="icon-check"></i></button>
                                                    </template>
                                                </td>
                                                <td v-text="lista.distrito"></td>
                                                <td v-text="lista.provincia"></td>
                                                <td v-text="lista.instancia"></td>
                                                <td v-text="lista.asunto"></td>
                                                
                                                <td v-text="lista.paquete"></td>
                                                <td v-text="lista.anaquel"></td>
                                                <td>
                                                    <div v-if="lista.condicion">
                                                        <span class="badge badge-success">Activo</span>
                                                    </div>
                                                    <div v-else>
                                                        <span class="badge badge-danger">Anulado</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="8">
                                                    No hay registros
                                                </td>
                                            </tr>
                                        </tbody>  
                            </table>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page -1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                    <a class="page-link" href="#"  @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page +1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                     <!-- FIN LISTADO -->
                     <!-- Registro -->
                    <template v-else-if="listado==0">
                       <div class="card-body">
                        
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Procedencia</h3>
                                <div class="card-tools">
                                    <a href="#form1" class="btn btn-tool" data-toggle="collapse"><i class="fa fa-minus"></i></a>

                                </div>
                            </div>
                            <div id="form1" class="collapse card-body">
                                 <div class="form-group row border">
                           
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Distrito Judicial</label>
                                            <select class="form-control" v-model="iddjudicial" @change='selectProvincia()'>
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="distrito in arrayDistrito" :key="distrito.id" :value="distrito.id" v-text="distrito.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Provincia</label>
                                            <select class="form-control" v-model="idpjudicial" @change='selectOrgano()'>
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="provincia in arrayProvincia" :key="provincia.id" :value="provincia.id" v-text="provincia.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Organo Jurisdiccional</label>
                                            <select class="form-control" v-model="idojudicial" @change='selectInstancia()'>
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="organo in arrayOrgano" :key="organo.id" :value="organo.id" v-text="organo.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Instancia</label>
                                            <select class="form-control" v-model="idijudicial" >
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="instancia in arrayInstancia" :key="instancia.id" :value="instancia.id" v-text="instancia.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                   
                                
                                </div>
                            </div>

                        </div>
                       <div class="card card-default">
                           <div class="card-header">
                                <h3 class="card-title">Legajo</h3>
                                <div class="card-tools">
                                    <a href="#form2" class="btn btn-tool" data-toggle="collapse"><i class="fa fa-minus"></i></a>

                                </div>
                            </div>
                            <div id="form2" class="collapse card-body">
                                <div class="form-group row border">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="text-input">Asunto</label>
                                            <input  type="text" v-model="asunto" class="form-control" maxlength="199"  placeholder="Asunto">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Anaquel</label>
                                            <input  type="text"  v-model="anaquel"  class="form-control" @keypress="soloNumero" maxlength="10" placeholder="Anaquel">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Paquete</label>
                                            <input  type="text"  v-model="paquete"  class="form-control" @keypress="soloNumero" maxlength="10" placeholder="Paquete">
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>
                       <div class="card card-default">
                           <div class="card-header">
                                <h3 class="card-title">Detalle Legajo</h3>
                                <div class="card-tools">
                                    <a href="#form3" class="btn btn-tool" data-toggle="collapse"><i class="fa fa-minus"></i></a>

                                </div>
                            </div>
                            <div id="form3" class="collapse card-body">
                                 <div class="form-group row border">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="text-input">Descripcion</label>
                                            <textarea  type="text" v-model="descripcion" class="form-control" rows="5" ref="Descripción" placeholder="Ingrese descripción del legajo"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="text-input">Observacion</label>
                                            <input  type="text"  v-model="observacion"  class="form-control" maxlength="199" placeholder="Observación" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input">Año</label>
                                            <input  type="text" v-model="anio_legajo" class="form-control" @keypress="soloNumero" maxlength="4" placeholder="Anio" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input">Folio</label>
                                            <input  type="text" v-model="folio" class="form-control" @keypress="soloNumero" maxlength="10" placeholder="Folios" >
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                                <label for="text-input">Estado</label>
                                                <select class="form-control" v-model="estado_legajo">
                                                    <option value="0" disabled>Seleccione</option>
                                                    <option v-for="estado in arrayEstadoLegajo" :key="estado.value" :value="estado.value" v-text="estado.nombre"></option>
                                                    
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="">Agregar</label>
                                            <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar"><i class="fa fa-plus"></i></button>    
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div v-show="errorDetalle" class="form-group row div-error">
                                            <div class="text-center text-error">
                                                <div v-for="error in errorMostrarMsjDetalle" :key="error" v-text="error">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-12">
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Opcion</th>
                                                    <th>Descripción</th>
                                                    <th>Observación</th>
                                                    <th>Año</th>
                                                    <th>Folios</th>
                                                    <th>Estado</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody v-if="arrayDetalle.length">
                                                <tr v-for="(det1,index) in arrayDetalle" :key="det1.id">
                                                    <td>
                                                        <button @click="eliminarDetalle(index)"  type="button" class="btn btn-danger btn-sm">
                                                            <i class="icon-close"></i>
                                                        </button>
                                                    </td>
                                                    <td height="80">
                                                        <textarea style="word-break: break-all;height: 100%; resize: none;width:100%;text-align:justify; font-size: 12px;font-family: monospace; " v-text="det1.descripcion" readonly>
                                                        </textarea>
                                                    </td>
                                                    <td v-text="det1.observacion"></td>
                                                    <td v-text="det1.anio_legajo"></td>
                                                    <td v-text="det1.folio"></td>
                                                    <td v-text="det1.estado_legajo"></td>
                                                    
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="6">
                                                        No hay registros
                                                    </td>
                                                </tr>
                                            </tbody>  
                                        </table>
                                    </div>
                                </div>
                            </div>
                       </div>
                       
                       
                       
                        
                        <div class="col-md-12">
                                <div v-show="errorRegistro" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjRegistro" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                               <button type="button" class="btn btn-primary" @click="registrarRegistro()">Guardar</button>
                            </div>
                        </div>
                       </div>
                    </template>
                     <!-- FIN REGISTRO -->
                     <!-- EDITAR -->
                     <template v-else-if="listado==2">
                         <div class="card-body">
                        
                        <div class="card card-default">
                            <div class="card-header">
                                <h3 class="card-title">Procedencia</h3>
                                <div class="card-tools">
                                    <a href="#form1" class="btn btn-tool" data-toggle="collapse"><i class="fa fa-minus"></i></a>

                                </div>
                            </div>
                            <div id="form1" class="collapse card-body">
                                 <div class="form-group row border">
                           
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Distrito Judicial</label>
                                            <select class="form-control" v-model="iddjudicial" @change='selectProvincia()'>
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="distrito in arrayDistrito" :key="distrito.id" :value="distrito.id" v-text="distrito.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Provincia</label>
                                            <select class="form-control" v-model="idpjudicial" @change='selectOrgano()'>
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="provincia in arrayProvincia" :key="provincia.id" :value="provincia.id" v-text="provincia.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Organo Jurisdiccional</label>
                                            <select class="form-control" v-model="idojudicial" @change='selectInstancia()'>
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="organo in arrayOrgano" :key="organo.id" :value="organo.id" v-text="organo.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Instancia</label>
                                            <select class="form-control" v-model="idijudicial" >
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="instancia in arrayInstancia" :key="instancia.id" :value="instancia.id" v-text="instancia.nombre"></option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                   
                                
                                </div>
                            </div>

                        </div>
                       <div class="card card-default">
                           <div class="card-header">
                                <h3 class="card-title">Legajo</h3>
                                <div class="card-tools">
                                    <a href="#form2" class="btn btn-tool" data-toggle="collapse"><i class="fa fa-minus"></i></a>

                                </div>
                            </div>
                            <div id="form2" class="collapse card-body">
                                <div class="form-group row border">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="text-input">Asunto</label>
                                            <input  type="text" v-model="asunto" class="form-control" maxlength="199"  placeholder="Asunto">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Anaquel</label>
                                            <input  type="text"  v-model="anaquel"  class="form-control" @keypress="soloNumero" maxlength="10" placeholder="Anaquel">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="text-input">Paquete</label>
                                            <input  type="text"  v-model="paquete"  class="form-control" @keypress="soloNumero" maxlength="10" placeholder="Paquete">
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>
                       <div class="card card-default">
                           <div class="card-header">
                                <h3 class="card-title">Detalle Legajo</h3>
                                <div class="card-tools">
                                    <a href="#form3" class="btn btn-tool" data-toggle="collapse"><i class="fa fa-minus"></i></a>

                                </div>
                            </div>
                            <div id="form3" class="collapse card-body">
                                 <div class="form-group row border">

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="text-input">Descripcion</label>
                                            <textarea  type="text" v-model="descripcion" class="form-control" rows="5" ref="Descripción" placeholder="Ingrese descripción del legajo"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="text-input">Observacion</label>
                                            <input  type="text"  v-model="observacion"  class="form-control" maxlength="199" placeholder="Observación" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input">Año</label>
                                            <input  type="text" v-model="anio_legajo" class="form-control" @keypress="soloNumero" maxlength="4" placeholder="Anio" >
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input">Folio</label>
                                            <input  type="text" v-model="folio" class="form-control" @keypress="soloNumero" maxlength="10" placeholder="Folios" >
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                                <label for="text-input">Estado</label>
                                                <select class="form-control" v-model="estado_legajo">
                                                    <option value="0" disabled>Seleccione</option>
                                                    <option v-for="estado in arrayEstadoLegajo" :key="estado.value" :value="estado.value" v-text="estado.nombre"></option>
                                                    
                                                </select>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="">Agregar</label>
                                            <button @click="registrarDetalle()" class="btn btn-success form-control btnagregar"><i class="fa fa-plus"></i></button>    
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <p class="col-md-12" style="background-color:#F97E2F;">(*Importante: Al agregar un registro o eliminar, la actualizacíon es directamente a la BD)</p>
                                    </div>
                                    <div class="col-md-12">
                                        <div v-show="errorDetalle" class="form-group row div-error">
                                            <div class="text-center text-error">
                                                <div v-for="error in errorMostrarMsjDetalle" :key="error" v-text="error">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive col-md-12">
                                        <table class="table table-bordered table-striped table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Opcion</th>
                                                    <th>Descripción</th>
                                                    <th>Observación</th>
                                                    <th>Año</th>
                                                    <th>Folios</th>
                                                    <th>Estado</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody v-if="arrayDetalle.length">
                                                <tr v-for="det1 in arrayDetalle" :key="det1.id">
                                                    <td>
                                                        <template v-if="det1.condicion=='1'">
                                                        <button @click="desactivarDetalle(det1.id)"  type="button" class="btn btn-danger btn-sm">
                                                            <i class="icon-close"></i>
                                                        </button>  
                                                        </template>
                                                        <template v-else>
                                                            <button type="button" class="btn btn-success btn-sm" @click="activarDetalle(det1.id)">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </template>
                                                    </td>
                                                    <td height="80">
                                                        <textarea style="word-break: break-all;height: 100%; resize: none;width:100%;text-align:justify; font-size: 12px;font-family: monospace; " v-text="det1.descripcion" readonly>
                                                        </textarea>
                                                    </td>
                                                    <td v-text="det1.observacion"></td>
                                                    <td v-text="det1.anio_legajo"></td>
                                                    <td v-text="det1.folio"></td>
                                                    <td v-text="det1.estado_legajo"></td>
                                                    
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr>
                                                    <td colspan="6">
                                                        No hay registros
                                                    </td>
                                                </tr>
                                            </tbody>  
                                        </table>
                                    </div>
                                </div>
                            </div>
                       </div>
                       
                       
                       
                        
                        <div class="col-md-12">
                                <div v-show="errorRegistro" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjRegistro" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                               <button type="button" class="btn btn-primary" @click="actualizarRegistro()">Actualizar</button>
                            </div>
                        </div>
                       </div>
                     </template>
                     <!-- FIN EDITAR -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
             <!-- INICIO MODAL -->
   

     <!-- FIN MODAL -->
        
            
        </section>
</template>

<script>

    export default {
       
        props: ['ruta'],
        data(){
            
            return {
                seleccion_id: 0,
                arrayListado: [],
                idresponsable: 0,
                idusuario: 0,
                arrayUsuario: [],
                estado: '',
                fecha_sistema: '',
                fecha_completa: '',

                iddjudicial: 0,
                idpjudicial: 0,
                idojudicial: 0,
                idijudicial: 0,
                arrayDistrito: [],
                arrayProvincia: [],
                arrayOrgano: [],
                arrayInstancia: [],

                asunto: '',
                anaquel: '',
                paquete: '',

                descripcion: '',
                observacion: '',
                anio_legajo: '',
                folio: '',
                estado_legajo: '',
                
                
                arrayEstadoLegajo:[{value: 'PARA ARCHIVO',nombre: 'PARA ARCHIVO'},
                ],
                

               
                arrayDetalle: [],
                errorDetalle: 0,
                errorMostrarMsjDetalle: [],

                listado: 1,
                titulo: '',
                errorRegistro: 0,
                errorMostrarMsjRegistro: [],
                pagination :{
                        'total' :0,
                        'current_page' :0,
                        'per_page' :0,
                        'last_page' :0,
                        'from' :0,
                        'to' :0,
                },
                offset: 3,
                criterio: 'anaquel',
                buscar: '',
                anio: '',
                
                
            }
        },
        
        
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            // calcula los elementos de la paginacion
            pagesNumber: function(){
                if(!this.pagination.to){
                    return [];
                }
                var from = this.pagination.current_page - this.offset;
                if(from < 1){
                    from = 1;
                }
                var to = from + (this.offset * 2);
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }
                var pagesArray=[];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
            
            

        },
        methods : {
            //METODOS PARA LISTAR REGISTRO
        listarConsulta(page,buscar,criterio){
                let me=this;
                
                var url=me.ruta + '/legajo?page=' + page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayListado = respuesta.consultas.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cambiarPagina(page,buscar,criterio){
            let me = this;
            //actualiza la pagina actual
            me.pagination.current_page=page;
            // envia la peticion para visualizar la data de esa pagina
            me.listarConsulta(page,buscar,criterio);

        },
        //METODOS PARA OBTENER PROCEDENCIA
        selectDistrito(){
            let me=this;
                var url=me.ruta + '/djudicial/selectDistritoJudicial';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayDistrito = respuesta.consultas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectProvincia(){
            let me=this;
                var url=me.ruta + '/pjudicial/comboProvinciaJudicial';
                axios.get(url,{
                    params: {
                        iddjudicial: this.iddjudicial
                 }
                 }).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayProvincia = respuesta.consultas;
                    
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectOrgano(){
            let me=this;
                var url=me.ruta + '/ojudicial/comboOrganoJudicial';
                axios.get(url,{
                    params: {
                        idpjudicial: this.idpjudicial
                 }
                 }).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayOrgano = respuesta.consultas;
                    
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectInstancia(){
            let me=this;
                var url=me.ruta + '/ijudicial/comboInstanciaJudicial';
                axios.get(url,{
                    params: {
                        idojudicial: this.idojudicial
                 }
                 }).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayInstancia = respuesta.consultas;
                    
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
       
        // METODOS PARA ABRIR FORMULARIO CON DATOS NECESARIOS PARA REGISTRO
        cargarCombos(){
            this.selectDistrito();
            this.selectProvincia();
            this.selectOrgano();
            this.selectInstancia();
        },
        registrarNuevo(){
            let me=this;
            this.listado=0;
            this.limpiarCampo();
            this.iddjudicial=1;
            this.idpjudicial=1;
            this.idojudicial=2;
            this.idijudicial=2;
            this.cargarCombos();
            this.limpiarDetalle();
            //this.obtenerProcedencia();
           
        },
        obtenerProcedencia(){
            let me=this;
             var arrayT=[];

            var url=me.ruta + '/ingreso/obtenerProcedencia?id='+me.idingreso;
            axios.get(url).then(function (response) {
                var respuesta=response.data;
                arrayT = respuesta.consulta;
                me.distrito = arrayT[0]['distrito'];
                me.provincia = arrayT[0]['provincia'];
                me.organo = arrayT[0]['organo'];
                me.instancia = arrayT[0]['instancia'];
                me.direccion = arrayT[0]['direccion'];
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        asignarFocus(){
            this.$nextTick(() => {
                const editButtonRef = this.$refs.cantidad;
                editButtonRef.focus();
            });
        },
        
        agregarDetalle(){
            let me=this;
            var fecha2= this.fecha_sistema.substr(0,4); 
            if(this.validarDetalle1()){
                return;
            }
            else{
                me.arrayDetalle.push({
                    descripcion: me.descripcion,
                    observacion: me.observacion,
                    anio_legajo: me.anio_legajo,
                    folio: me.folio,
                    estado_legajo: me.estado_legajo,
                    
                });
                me.descripcion='';
                me.observacion='';
                me.anio_legajo=fecha2;
                me.folio='';
                me.estado_legajo='PARA ARCHIVO';   
                
            }  
        },
       
        eliminarDetalle(index){
            let me = this;
            me.arrayDetalle.splice(index, 1);
        },
       
        validarDetalle1(){
            this.errorDetalle=0;
                this.errorMostrarMsjDetalle =[];
                if (!this.descripcion) this.errorMostrarMsjDetalle.push("Ingrese descripción");
                if (!this.anio_legajo) this.errorMostrarMsjDetalle.push("Ingrese año");
                if (!this.folio) this.errorMostrarMsjDetalle.push("Ingrese folios");
                if (!this.estado_legajo || this.estado_legajo==0) this.errorMostrarMsjDetalle.push("Seleccion un estado");
                if (this.errorMostrarMsjDetalle.length) this.errorDetalle = 1;
                return this.errorDetalle;
        },
       limpiarDetalle(){
           var fecha2= this.fecha_sistema.substr(0,4);
           this.descripcion='';
           this.observacion='';
           this.anio_legajo=fecha2;
           this.folio='';
           this.estado_legajo='PARA ARCHIVO';
       },
       
        
        validarRegistro(){
            this.errorRegistro=0;
            this.errorMostrarMsjRegistro=[];
            if(this.idusuario==0) this.errorMostrarMsjRegistro.push("Error de usuario, reinicie sesión");
            if(this.idijudicial==0) this.errorMostrarMsjRegistro.push("Seleccione una instancia");
            if(!this.asunto) this.errorMostrarMsjRegistro.push("Ingrese un asunto");
            if(!this.anaquel) this.errorMostrarMsjRegistro.push("Ingrese número de anaquel");
            if(!this.paquete) this.errorMostrarMsjRegistro.push("Ingrese número de paquete");
            if(this.arrayDetalle.length==0) this.errorMostrarMsjRegistro.push("Se requiere almenos una descripción");
   
            if(this.errorMostrarMsjRegistro.length) this.errorRegistro=1;
            return this.errorRegistro;
        },

        // METODOS PARA REGISTRAR
        registrarRegistro(){
            let me=this;
            var num=0;
            if(this.validarRegistro()){
                return;
            }
            axios.post(me.ruta + '/legajo/registrar',{
                'idijudicial': this.idijudicial,
                'asunto': this.asunto,
                'anaquel': this.anaquel,
                'paquete': this.paquete,
                'idusuario': this.idusuario,
                'data1': this.arrayDetalle

               
                
            }).then(function(response){
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Registro con Éxito',
                showConfirmButton: false,
                timer: 1500
                })
               
                me.listado=1;
                me.listarConsulta(1,'','anaquel');
               
                me.limpiarCampo();

            }).catch(function(error){
                console.log(error);
            });
        },
        //METODOS PARA ACTUALIZAR FORMULARIO
        abrirActualizar(id){
            let me=this;
            me.listado=2;
             var arraySolicitudT1=[];
            var url=me.ruta + '/legajo/obtenerCabecera?id=' + id;
             axios.get(url).then(function (response) {
                var respuesta= response.data;
                arraySolicitudT1 = respuesta.consultas;
                me.seleccion_id =arraySolicitudT1[0]['id'];
                me.iddjudicial=arraySolicitudT1[0]['iddjudicial'];
                me.idpjudicial=arraySolicitudT1[0]['idpjudicial'];
                me.idojudicial=arraySolicitudT1[0]['idojudicial'];
                me.idijudicial=arraySolicitudT1[0]['idijudicial'];
                me.asunto=arraySolicitudT1[0]['asunto'];
                me.anaquel=arraySolicitudT1[0]['anaquel'];
                me.paquete=arraySolicitudT1[0]['paquete'];
                
                me.cargarCombos();
                me.obtenerDetalle1(me.seleccion_id);
                me.limpiarDetalle();
               
                
  
            })
            .catch(function (error) {
                console.log(error);
            }); 
        },
        obtenerDetalle1(id){
           let me=this;
                var url=me.ruta + '/legajo/obtenerDetalle1?id='+id;
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayDetalle = respuesta.consulta;
                    
                })
                .catch(function (error) {
                    console.log(error);
            });
        },
        actualizarRegistro(){
            let me= this;
            var num=0;
            if(this.validarRegistro()){
                return;
            }
            axios.put(me.ruta + '/legajo/actualizar',{
                'idijudicial': this.idijudicial,
                'asunto': this.asunto,
                'anaquel': this.anaquel,
                'paquete': this.paquete,
                'idusuario': this.idusuario,
                'id': this.seleccion_id
                
            }).then(function(response){
                //console.log(response.data);
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Actualización con Éxito',
                showConfirmButton: false,
                timer: 1500
                })
                num=me.numero_ingreso;
                me.listado=1;
                me.limpiarCampo();
                me.listarConsulta(1,'','anaquel');
               
            }).catch(function(error){
                console.log(error);
            });
        },
        registrarDetalle(){
            let me=this; 
            if(this.validarDetalle1()){
                return;
            }
            else{
                axios.post(me.ruta + '/legajo/registrarDetalle',{
                    'idlegajo': me.seleccion_id,
                    'descripcion': me.descripcion,
                    'observacion': me.observacion, 
                    'anio': me.anio_legajo,
                    'folio': me.folio,
                    'estado': me.estado_legajo

                }).then(function(response){
                    Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Registro Actualizado',
                    showConfirmButton: false,
                    timer: 1500
                    })
                    me.limpiarDetalle();
                    me.obtenerDetalle1(me.seleccion_id); 
                
                }).catch(function(error){
                    console.log(error);
                }); 
            }
        },
        activarDetalle(id){
           const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de activar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        axios.put(me.ruta + '/legajo/activarDetalle',{
                            'id': id
                           
                        }).then(function(response){
                            var idcuenta=me.seleccion_id;
                            me.obtenerDetalle1(idcuenta);
                             swalWithBootstrapButtons.fire(
                            'Activado!',
                            'El registro ha sido activado con éxito',
                            'success'
                        )
                        }).catch(function(error){
                            console.log(error);
                        });


                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        
                    }
                    })
        },
        desactivarDetalle(id){
           const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Está seguro de desactivar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        axios.put(me.ruta + '/legajo/desactivarDetalle',{
                            'id': id
                           
                        }).then(function(response){
                            var idcuenta=me.seleccion_id;
                            me.obtenerDetalle1(idcuenta);
                             swalWithBootstrapButtons.fire(
                            'Desactivado!',
                            'El registro ha sido desactivado con éxito',
                            'success'
                        )
                        }).catch(function(error){
                            console.log(error);
                        });


                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        
                    }
                    })
        },
        //ELIMINACION LOGICA REGISTROS
         desactivarRegistro(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de desactivar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        axios.put(me.ruta + '/legajo/desactivar',{
                            'id': id
                           
                        }).then(function(response){
        
                            me.listarConsulta(1,'','anaquel');
                             swalWithBootstrapButtons.fire(
                            'Desactivado!',
                            'El registro ha sido desactivado con éxito',
                            'success'
                        )
                        }).catch(function(error){
                            console.log(error);
                        });


                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        
                    }
                    })
        },
        activarRegistro(id){
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de activar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        axios.put(me.ruta + '/legajo/activar',{
                            'id': id
                           
                        }).then(function(response){
        
                            me.listarConsulta(1,'','anaquel');
                             swalWithBootstrapButtons.fire(
                            'Activado!',
                            'El registro ha sido activado con éxito',
                            'success'
                        )
                        }).catch(function(error){
                            console.log(error);
                        });


                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        
                    }
                    })
        },
       
        //OTROS METODOS
        
        soloNumero($event) {
        //console.log($event.keyCode); //keyCodes value
        let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57)) { // 46 is dot
                $event.preventDefault(); 
            }
        },
        soloLetra($event) {
        let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if (keyCode < 65 || (keyCode > 90 && keyCode < 97) || keyCode > 122) { 
                $event.preventDefault(); 
            }
        },
        obtenerUsuario(){
            let me=this;
                var url=me.ruta + '/user/obtenerPersona/';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayUsuario = respuesta.personas;
                    me.idresponsable=me.arrayUsuario[0].idpersona; 
                    me.idusuario=me.arrayUsuario[0].id;   
                    me.fecha_sistema=me.arrayUsuario[0].fecha;
                    me.fecha_completa=me.arrayUsuario[0].fecha_completa;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        ocultarDetalle(){
            this.listado=1;
            this.limpiarCampo();
            
        },
       
        limpiarCampo(){
            let me = this;
            me.errorRegistro=0;
            me.errorMostrarMsjRegistro=[];
            me.iddjudicial=1;
            me.idpjudicial=1;
            me.idojudicial=2;
            me.idijudicial=2;
            
            me.asunto='REMISIÓN DE LEGAJOS AL ARCHIVO CENTRAL';
            me.anaquel='';
            me.paquete='';
           
            me.errorDetalle=0;
            
            me.errorMostrarMsjDetalle=[];
            
            me.arrayDetalle= [];
            
           
        },
        reporte(id){
            let me=this;
            
            if(id==0){
                Swal.fire({
                    title: 'Error!',
                    text: 'Seleccione un registro',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    })
            }else{
                    
                  //  window.open(me.ruta + '/legajo/reporte?id='+id,'_blank'); 
                    id = window.btoa(id); 
                     window.open(me.ruta + '/legajo/reporte/'+id,'_blank');  
               
                   

               
            }
  
        }
        },
        mounted() {
           // this.listarConsulta(1,this.buscar,this.criterio);
            this.listarConsulta(1,'','anaquel');
            this.obtenerUsuario();
           
           
           
           
        }
    
        }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display:list-item !important;
        opacity:1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }
</style>