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
                        <i class="fa fa-align-justify"></i> Expedientes
                        <div class="form-group row">
                            
                            <label class="col-md-2 form-control-label" for="text-input">Total</label>
                            <div class="col-md-2">
                                <input  type="text" v-model="total_expediente"  class="form-control" readonly>
                                
                            </div>
                            <label class="col-md-2 form-control-label" for="text-input">Ingresados</label>
                            <div class="col-md-2">
                                <input  type="text" v-model="ingresado_expediente"  class="form-control" readonly>
                                
                            </div>
                            <label class="col-md-2 form-control-label" for="text-input">Por ingresar</label>
                            <div class="col-md-2">
                                <input  type="text" v-model="ingresado_pendiente"  class="form-control" readonly>
                                
                            </div>
                        </div>
                        
                        <input  type="text" id="num_ingreso" name="num_ingreso" v-model="numero_ingreso" @keyup.enter="validarNumero(buscar,criterio,numero_ingreso)" @keypress="soloNumero" 
                           maxlength="10" class="form-control" placeholder="Número de ingreso">
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="numero_expediente">Número Expediente</option>
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarConsulta(buscar,criterio,numero_ingreso)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarConsulta(buscar,criterio,numero_ingreso)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    &nbsp;&nbsp;
                                    <template v-if="existe1==1 && ingresado_pendiente>0">
                                    <button type="submit" @click="registrarNuevo()" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo</button>
                                    </template>
                                    <template v-if="arrayListado.length > 0">
                                        &nbsp;&nbsp;&nbsp;
                                        <button type="button" @click="reporte()" class="btn btn-warning">
                                            <i class="fa fa-file-pdf-o"></i>&nbsp;Reporte
                                        </button>  
                                    </template>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>Numero Ingreso</th>
                                        <th>Numero Expediente</th>
                                        <th>Instancia</th>
                                        <th>Estado</th>
                                        
                                    </tr>
                                </thead>
                               <tbody v-if="arrayListado.length">
                                            <tr v-for="lista in listarRegistroPaginated" :key="lista.id">
                                                 
                                                <td>
                                                    <template v-if="lista.condicion=='1'">
                                                       <button type="button" @click="abrirActualizar(lista.id)" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-pencil"></i></button>
                                                    </template>
                                                     &nbsp;
                                                    <template v-if="lista.condicion=='1'">
                                                        <button type="button" class="btn btn-danger btn-sm" @click="abrirModal('modal','anular',lista.id)">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </template>
                                                    <template v-else-if="lista.condicion=='0' && ingresado_pendiente>0">
                                                        <button type="button" class="btn btn-info btn-sm" @click="abrirModal('modal','restaurar',lista.id)">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </template>
                                                </td>
                                                <td v-text="lista.numero_ingreso"></td>
                                                <td v-text="lista.numero_expediente"></td>
                                                <td v-text="lista.instancia"></td>
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
                                        <td colspan="5">
                                            No hay registros
                                        </td>
                                    </tr>
                                </tbody>  
                            </table>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <nav>
                            <ul class="pagination pagination-sm m-0 float-right">
                                <li class="page-item" v-if="pageNumber>0">
                                    <a href="#" class="page-link" @click.prevent="prevPage">Ant.</a>
                                </li>
                                <li class="page-item" v-for="(page,index) in pagesList" :key="index" 
                                :class="[page==pageNumber ? 'active':'']">
                                    <a href="#" class="page-link" @click.prevent="selectPage(page)">{{page+1}}</a>
                                </li>
                                <li class="page-item" v-if="pageNumber<pageCount-1">
                                    <a href="#" class="page-link" @click.prevent="nextPage">Post.</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                     <!-- FIN LISTADO -->
                     <!-- Registro -->
                    <template v-else-if="listado==0">
                       <div class="card-body">
                        <div class="form-group row border">
                          
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text-input">Número Ingreso</label>
                                     <input  type="text" v-model="numero_ingreso1" class="form-control" placeholder="" readonly>
                                    
                                </div>
                            </div>
                           <div class="col-md-8">
                                <div class="form-group">
                                    <label for="text-input">Código Expediente</label>
                                    <barcode v-bind:value="barcodeValue" height="25">
                                        Show this if the rendering fails.
                                    </barcode>
                                </div>
                            </div>
                           
                           
                        </div>
                        <div>
                            <h3 class="font-bold text-xs mc-section-title">Procedencia</h3>
                                <div class="form-group row border">
                        
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Distrito Judicial</label>
                                        <input  type="text" v-model="distrito"   class="form-control" placeholder="Distrito judicial" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Provincia</label>
                                        <input  type="text" v-model="provincia"   class="form-control" placeholder="Provincia" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Organo Jurisdiccional</label>
                                        <input  type="text" v-model="organo"   class="form-control" placeholder="Organo Jurisdiccional" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Instancia</label>
                                        <input  type="text" v-model="instancia"   class="form-control" placeholder="Instancia" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="text-input">Dirección</label>
                                        <input  type="text" v-model="direccion"   class="form-control" placeholder="Direccion" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="text-input">Responsable origen</label>
                                        <input  type="text" v-model="responsable"   class="form-control" placeholder="Responsable origen">
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                       <div>
                            <h3 class="font-bold text-xs mc-section-title">Expediente</h3>
                            <div class="form-group row border">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Especialidad</label>
                                        <select class="form-control" v-model="idespecialidad">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="especialidad in arrayEspecialidad" :key="especialidad.id" :value="especialidad.id" v-text="especialidad.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Expediente-Año</label>
                                        <input  type="text" v-model="anio_expediente"   class="form-control" @keypress="soloNumero" maxlength="4"  placeholder="Año Exp.">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Expediente-Número</label>
                                        <input  type="text" v-model="numero_expediente"   class="form-control" placeholder="Núm. Exp.">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">T. Expediente</label>
                                        <select class="form-control" v-model="idtexpediente">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="texpediente in arrayTExpediente" :key="texpediente.id" :value="texpediente.id" v-text="texpediente.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="text-input">Número de folios</label>
                                        <input  type="text" v-model="folio"   class="form-control" @keypress="soloNumero" placeholder="Número de folios">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="text-input">Número de cuadernos</label>
                                        <input  type="text" v-model="cuaderno"   class="form-control" @keypress="soloNumero" placeholder="Número de cuadernos">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="text-input">Estado</label>
                                        <select class="form-control" v-model="idestado">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="estadoe in arrayEstado" :key="estadoe.id" :value="estadoe.id" v-text="estadoe.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Tipo Archivo</label>
                                        <select class="form-control" v-model="idtarchivo">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tarchivo in arrayTArchivo" :key="tarchivo.id" :value="tarchivo.id" v-text="tarchivo.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Fecha Conclusión</label>
                                        <input  type="date" v-model="fecha_conclusion"   class="form-control" placeholder="Instancia" >
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="text-input" style="display: none">Tipo Conclusión</label>
                                        <select class="form-control" v-model="idtconclusion" style="display: none">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tconclusion in arrayTConclusion" :key="tconclusion.id" :value="tconclusion.id" v-text="tconclusion.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="text-input" style="display: none">Expediente</label>
                                        <input  type="text" v-model="numero_origen"   class="form-control" placeholder="Expediente" readonly style="display: none">
                                    </div>
                                </div>
                            
                            </div>
                       </div>
                       <div>
                            <h3 class="font-bold text-xs mc-section-title">Recepción</h3>
                            <div class="form-group row border">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Fecha recepción</label>
                                        <input  type="date" v-model="fecha_recepcion"   class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Local</label>
                                        <select class="form-control" v-model="idlocal">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="local in arrayLocal" :key="local.id" :value="local.id" v-text="local.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Anaquel</label>
                                        <input  type="text" v-model="anaquel"   class="form-control" placeholder="Anaquel" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Paquete</label>
                                        <input  type="text" v-model="paquete"   class="form-control" placeholder="Paquete" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="text-input">Observación</label>
                                        <textarea v-model="observacion" type="text" class="form-control" rows="2" ref="observacion"></textarea>
                                    </div>
                                </div>

                            </div>
                       </div>
                       <div>
                            <h3 class="font-bold text-xs mc-section-title">Partes Procesales</h3>
                            <div class="form-group row border">                           
                                <div class="col-md-2">
                                    <div class="form-group">
                                            <label for="text-input">Part. proce.</label>
                                            <select class="form-control" v-model="idpprocesal" @change="obtenerNombrePProcesal()">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="procesal in arrayPProcesal" :key="procesal.id" :value="procesal.id" v-text="procesal.nombre"></option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                            <label for="text-input">C. pers.</label>
                                            <select class="form-control" v-model="idcpersona" @change="obtenerNombreCPersona()">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="cpersona in arrayCPersona" :key="cpersona.id" :value="cpersona.id" v-text="cpersona.nombre"></option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Apell/R.Social</label>
                                        <input  type="text" v-model="apellido"   class="form-control" placeholder="Apell/R.Social">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Nombre</label>
                                        <input  type="text" v-model="nombre"  @keyup.enter="agregarDetalle()" @keypress="soloLetra" class="form-control" placeholder="Nombre">
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
                                                <th>P.procesal</th>
                                                <th>C.persona</th>
                                                <th>Apell/Razon Social</th>
                                                <th>Nombre</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalle.length">
                                            <tr v-for="(det1,index) in arrayDetalle" :key="det1.id">
                                                <td>
                                                    <button @click="eliminarDetalle(index)"  type="button" class="btn btn-danger btn-sm">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </td>
                                                <td v-text="det1.nom_pprocesal"></td>
                                                <td v-text="det1.nom_cpersona"></td>
                                                <td v-text="det1.apellido"></td>
                                                <td v-text="det1.nombre"></td>
                                                
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5">
                                                    No hay partes procesales agregados
                                                </td>
                                            </tr>
                                        </tbody>  
                                    </table>
                                </div>
                            </div>
                       </div>
                        <div>
                            <h3 class="font-bold text-xs mc-section-title">Materia delito</h3>
                            <div class="form-group row border">
                                
                                <div class="col-md-10">
                                    <div class="form-group">
                                            <select class="form-control" v-model="idmateria" @change="obtenerNombreMateria()">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="materia in arrayMateria" :key="materia.id" :value="materia.id" v-text="materia.nombre"></option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Agregar</label>
                                        <button @click="agregarDetalle1()" class="btn btn-success form-control btnagregar"><i class="fa fa-plus"></i></button>    
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div v-show="errorDetalle1" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjDetalle1" :key="error" v-text="error">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Opcion</th>
                                                
                                                <th>Materia Delito</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalle1.length">
                                            <tr v-for="(det2,index) in arrayDetalle1" :key="det2.id">
                                                <td>
                                                    <button @click="eliminarDetalle1(index)"  type="button" class="btn btn-danger btn-sm">
                                                        <i class="icon-close"></i>
                                                    </button>
                                                </td>
                                                
                                                <td v-text="det2.nom_materia"></td>
                                            
                                                
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="2">
                                                    No hay materia/delito agregados
                                                </td>
                                            </tr>
                                        </tbody>  
                                    </table>
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
                        <div class="form-group row border">
                           <div class="col-md-12">
                                <div class="form-group">
                                    <label for="text-input">Código Expediente</label>
                                    <barcode v-bind:value="codigo_expediente" height="25">
                                        Show this if the rendering fails.
                                    </barcode>
                                </div>
                            </div>
                           
                           
                        </div>
                        <div>
                            <h3 class="font-bold text-xs mc-section-title">Procedencia</h3>
                            <div class="form-group row border">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Distrito Judicial</label>
                                        <input  type="text" v-model="distrito"   class="form-control" placeholder="Distrito judicial" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Provincia</label>
                                        <input  type="text" v-model="provincia"   class="form-control" placeholder="Provincia" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Organo Jurisdiccional</label>
                                        <input  type="text" v-model="organo"   class="form-control" placeholder="Organo Jurisdiccional" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Instancia</label>
                                        <input  type="text" v-model="instancia"   class="form-control" placeholder="Instancia" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="text-input">Dirección</label>
                                        <input  type="text" v-model="direccion"   class="form-control" placeholder="Direccion" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="text-input">Responsable origen</label>
                                        <input  type="text" v-model="responsable"   class="form-control" placeholder="Responsable origen">
                                    </div>
                                </div>
                            
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-xs mc-section-title">Expediente</h3>
                            <div class="form-group row border">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Especialidad</label>
                                        <select class="form-control" v-model="idespecialidad">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="especialidad in arrayEspecialidad" :key="especialidad.id" :value="especialidad.id" v-text="especialidad.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Expediente-Año</label>
                                        <input  type="text" v-model="anio_expediente"   class="form-control" @keypress="soloNumero" maxlength="4" placeholder="Año Exp.">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Expediente-Número</label>
                                        <input  type="text" v-model="numero_expediente"   class="form-control" placeholder="Núm. Exp.">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Tipo Expediente</label>
                                        <select class="form-control" v-model="idtexpediente">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="texpediente in arrayTExpediente" :key="texpediente.id" :value="texpediente.id" v-text="texpediente.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="text-input">Número de folios</label>
                                        <input  type="text" v-model="folio"   class="form-control" @keypress="soloNumero" placeholder="Número de folios">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="text-input">Número de cuadernos</label>
                                        <input  type="text" v-model="cuaderno"   class="form-control" @keypress="soloNumero" placeholder="Número de cuadernos">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="text-input">Estado</label>
                                        <select class="form-control" v-model="idestado">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="estadoe in arrayEstado" :key="estadoe.id" :value="estadoe.id" v-text="estadoe.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Tipo Archivo</label>
                                        <select class="form-control" v-model="idtarchivo">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tarchivo in arrayTArchivo" :key="tarchivo.id" :value="tarchivo.id" v-text="tarchivo.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Fecha Conclusión</label>
                                        <input  type="date" v-model="fecha_conclusion"   class="form-control" placeholder="Instancia" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input" style="display: none">Tipo Conclusión</label>
                                        <select class="form-control" v-model="idtconclusion" style="display: none">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="tconclusion in arrayTConclusion" :key="tconclusion.id" :value="tconclusion.id" v-text="tconclusion.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="text-input" style="display: none">Expediente</label>
                                            <input  type="text" v-model="numero_origen"   class="form-control" placeholder="Expediente" readonly style="display: none">
                                        </div>
                                    </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-xs mc-section-title">Recepción</h3>
                            <div class="form-group row border">
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Fecha recepción</label>
                                        <input  type="date" v-model="fecha_recepcion"   class="form-control" >
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Local</label>
                                        <select class="form-control" v-model="idlocal">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="local in arrayLocal" :key="local.id" :value="local.id" v-text="local.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Anaquel</label>
                                        <input  type="text" v-model="anaquel"   class="form-control" placeholder="Anaquel" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Paquete</label>
                                        <input  type="text" v-model="paquete"   class="form-control" placeholder="Paquete" readonly>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="text-input">Observación</label>
                                        <textarea v-model="observacion" type="text" class="form-control" rows="2" ref="observacion"></textarea>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-xs mc-section-title">Partes Procesales</h3>
                            <div class="form-group row border">
                                <p class="col-md-12" style="background-color:#F97E2F; color: #fff">(*Importante: Al agregar un registro o eliminar, la actualizacíon es directamente a la BD)</p>
                                <div class="col-md-2">
                                    <div class="form-group">
                                            <label for="text-input">Part. proce.</label>
                                            <select class="form-control" v-model="idpprocesal" @change="obtenerNombrePProcesal()">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="procesal in arrayPProcesal" :key="procesal.id" :value="procesal.id" v-text="procesal.nombre"></option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                            <label for="text-input">C. pers.</label>
                                            <select class="form-control" v-model="idcpersona" @change="obtenerNombreCPersona()">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="cpersona in arrayCPersona" :key="cpersona.id" :value="cpersona.id" v-text="cpersona.nombre"></option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Apell/R.Social</label>
                                        <input  type="text" v-model="apellido"   class="form-control" placeholder="Apell/R.Social">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="text-input">Nombre</label>
                                        <input  type="text" v-model="nombre"  @keyup.enter="registrarDetalle()" @keypress="soloLetra" class="form-control" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <div class="form-group">
                                        <label for="">Agregar</label>
                                        <button @click="registrarDetalle()" class="btn btn-success form-control btnagregar"><i class="fa fa-plus"></i></button>    
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
                                                <th>P.procesal</th>
                                                <th>C.persona</th>
                                                <th>Apell/Razon Social</th>
                                                <th>Nombre</th>
                                                
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
                                                        <button type="button" class="btn btn-info btn-sm" @click="activarDetalle(det1.id)">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </template>
                                                </td>
                                                <td v-text="det1.nom_pprocesal"></td>
                                                <td v-text="det1.nom_cpersona"></td>
                                                <td v-text="det1.apellido"></td>
                                                <td v-text="det1.nombre"></td>
                                                
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5">
                                                    No hay partes procesales agregados
                                                </td>
                                            </tr>
                                        </tbody>  
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3 class="font-bold text-xs mc-section-title">Materia delito</h3>
                            <div class="form-group row border">
                                <p class="col-md-12" style="background-color:#F97E2F; color: #fff">(*Importante: Al agregar un registro o eliminar, la actualizacíon es directamente a la BD)</p>
                                <div class="col-md-10">
                                    <div class="form-group">
                                            <select class="form-control" v-model="idmateria" @change="obtenerNombreMateria()">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="materia in arrayMateria" :key="materia.id" :value="materia.id" v-text="materia.nombre"></option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="">Agregar</label>
                                        <button @click="registrarDetalle1()" class="btn btn-success form-control btnagregar"><i class="fa fa-plus"></i></button>    
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div v-show="errorDetalle1" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjDetalle1" :key="error" v-text="error">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive col-md-12">
                                    <table class="table table-bordered table-striped table-sm">
                                        <thead>
                                            <tr>
                                                <th>Opcion</th>
                                                
                                                <th>Materia Delito</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayDetalle1.length">
                                            <tr v-for="det2 in arrayDetalle1" :key="det2.id">
                                                <td>
                                                    <template v-if="det2.condicion=='1'">
                                                    <button @click="desactivarDetalle1(det2.id)"  type="button" class="btn btn-danger btn-sm">
                                                        <i class="icon-close"></i>
                                                    </button>  
                                                    </template>
                                                    <template v-else>
                                                        <button type="button" class="btn btn-info btn-sm" @click="activarDetalle1(det2.id)">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </template>
                                                </td>
                                                
                                                <td v-text="det2.nom_materia"></td>
                                            
                                                
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="2">
                                                    No hay materia/delito agregados
                                                </td>
                                            </tr>
                                        </tbody>  
                                    </table>
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
    <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
            </div>
            <div class="modal-body">
              <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                                    <div class="col-md-9">
                                        <input  type="text"  v-model="estado_anulado"   class="form-control" readonly>
                                        
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Motivo</label>
                                    <div class="col-md-9">
                                        <textarea v-model="motivo_anulado" type="text" class="form-control" rows="2"></textarea>
                                        
                                    </div>
                                </div>
                                <div v-show="errorAnulado" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjAnulado" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarAnulado()">Anular</button>
                <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="restaurarAnulado()">Restaurar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

     <!-- FIN MODAL -->
        
            
        </section>
</template>

<script>
import VueBarcode from 'vue-barcode';
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

                numero_ingreso: '',
                existe1: 0,

                total_expediente: 0,
                ingresado_expediente: 0,
                ingresado_pendiente: 0,

                numero_ingreso1: '',
                codigo_expediente: '',
                distrito: '',
                provincia: '',
                organo: '',
                instancia: '',
                idingreso: 0,
                direccion: '',
                responsable: '',
                idespecialidad: 0,
                arrayEspecialidad: [],
                numero_origen: '',
                anio_expediente: '',
                numero_expediente: '',
                idtexpediente: 0,
                arrayTExpediente: [],
                folio: 0,
                cuaderno: 0,
                idestado: 0,
                arrayEstado: [],
                idtarchivo: 0,
                arrayTArchivo: [],
                fecha_conclusion: '',
                idtconclusion: 0,
                arrayTConclusion: [],

                fecha_recepcion: '',
                idlocal: 0,
                arrayLocal: [],
                anaquel: '',
                paquete: '',
                observacion: '',

                idpprocesal: 0,
                nom_pprocesal: '',
                arrayPProcesal: [],
                idcpersona: 0,
                nom_cpersona: '',
                arrayCPersona: [],
                apellido: '',
                nombre: '',
                arrayDetalle: [],
                errorDetalle: 0,
                errorMostrarMsjDetalle: [],

                idmateria: 0,
                nom_materia: '',
                arrayMateria: [],
                arrayDetalle1: [],
                errorDetalle1: 0,
                errorMostrarMsjDetalle1: [],

                estado_anulado: '',
                motivo_anulado: '',
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorAnulado: 0,
                errorMostrarMsjAnulado: [],

                listado: 1,
                titulo: '',
                errorRegistro: 0,
                errorMostrarMsjRegistro: [],
               //paginacion
                 pageNumber: 0,
                perPage: 25, //se define cantidad de registro por mostrar por hoja
                //fin paginacion
                criterio: 'numero_expediente',
                buscar: '',
                anio: '',
                
                barcodeValue: '',
            }
        },
        components: {
            'barcode': VueBarcode
        },
        
        computed:{
            pageCount(){ //metodo para calcular la cantidad de paginas a mostrar
                let a=this.arrayListado.length,
                b=this.perPage;
                return Math.ceil(a/b);
            },
            listarRegistroPaginated(){//obtener registros paginados
                let inicio=this.pageNumber*this.perPage,
                    fin=inicio+this.perPage;
                return this.arrayListado.slice(inicio,fin);
            },
            pagesList(){
                let a=this.arrayListado.length,
                b=this.perPage;
                let pageCount=Math.ceil(a/b);
                let count=0,
                pagesArray=[];

                while (count<pageCount){
                pagesArray.push(count);
                count++;
                }
                return pagesArray;
            }
            
            

        },
        methods : {
           //METODOS PARA LISTAR REGISTRO
        nextPage(){
            this.pageNumber++;
        },
        prevPage(){
            this.pageNumber--;
        },
        selectPage(page){
            this.pageNumber = page;
        },
        inicializarPaginacion(){
            this.pageNumber=0;
        },
        listarConsulta(buscar,criterio,paquete){
                let me=this;
                
                var url=me.ruta + '/expediente?buscar='+buscar+'&criterio='+criterio+'&numero_ingreso='+paquete;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.inicializarPaginacion();
                    //console.log(respuesta);
                    me.arrayListado = respuesta;
                    //me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        validarNumero(){
            var existe=0;
            if(!this.numero_ingreso){
                Swal.fire({
                    title: 'Error!',
                    text: 'Se requiere número de ingreso',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    })
            }else{
                let me=this;
                var arrayT=[];
                var arrayT1=[];
                var total=0;
                var iding=0;
                var num=0;
                
                //me.existe=0;
                var url=me.ruta + '/ingreso/obtenerTotalNumero?numero='+this.numero_ingreso;
                axios.get(url).then(function (response) {
                   // console.log(response);
                   var respuesta=response.data;
                    arrayT = respuesta.consulta;
                    total = arrayT[0]['total'];
                   
                   if(parseInt(total)>0){
                       existe=1;
                       num=me.numero_ingreso;
                       //console.log(existe);
                       me.totales(num);
                       me.listarConsulta('','numero_expediente',num);
                       //me.totales(num);
                        me.existe1=existe;
                        var url1=me.ruta + '/ingreso/obtenerId?numero='+me.numero_ingreso;
                        axios.get(url1).then(function (response) {
                            var respuesta=response.data;
                            arrayT1 = respuesta.consulta;
                            iding = arrayT1[0]['id'];
                            me.idingreso=iding;
                            //console.log(iding);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                   }else{
                       me.existe1=existe;
                       //console.log(existe);
                       //console.log('XD');
                        Swal.fire({
                        position: 'top-end',
                        icon: 'info',
                        title: 'Número de ingreso no existe o se encuentra anulado',
                        showConfirmButton: false,
                        timer: 2000
                        })
                   }
                })
                .catch(function (error) {
                    console.log(error);
                });
              
            }
        },
        totales(num){
            let me=this;
            var arrayT=[];
            var arrayT1=[];
            var t1=0;
            var t2=0;
            var t3=0;
            var url=me.ruta + '/ingreso/obtenerCantidadExpediente?numero='+num;    
            axios.get(url).then(function (response) {
                var respuesta=response.data;
                arrayT = respuesta.consulta;
                t1 = arrayT[0]['cantidad'];
                
                var url1=me.ruta + '/expediente/obtenerExpedienteIngresado?numero='+num;    
                axios.get(url1).then(function (response) {
                var respuesta=response.data;
                arrayT1 = respuesta.consulta;
                t2 = arrayT1[0]['ingresados'];
                t3=parseInt(t1)-parseInt(t2);
                me.total_expediente=t1;
                me.ingresado_expediente=t2;
                me.ingresado_pendiente=t3;
                })
                .catch(function (error) {
                    console.log(error);
                });

             })
            .catch(function (error) {
                console.log(error);
            });
            
        },
        // METODOS PARA ABRIR FORMULARIO CON DATOS NECESARIOS PARA REGISTRO
        registrarNuevo(){
            let me=this;
            this.listado=0;
            this.limpiarCampo();
            this.numero_ingreso1=this.numero_ingreso;
            this.generarCodigo23();
            this.obtenerProcedencia();
            this.obtenerEspecialidad();
            this.obtenerTExpediente();
            this.obtenerEstado();
            this.obtenerTArchivo();
            this.obtenerTConclusion();
            this.numero_origen='001';
            this.fecha_conclusion=this.fecha_sistema;
            this.fecha_recepcion=this.fecha_sistema;
            this.obtenerLocal();
            this.idlocal=1;
            this.obtenerPProcesal();
            this.obtenerCPersona();
            this.obtenerMateria();
            this.anaquel=0;
            this.paquete=0;
            this.responsable='ODECMA';
            this.idespecialidad=1;
            this.idtexpediente=1;
            this.idestado=1;
            this.idtarchivo=1;
            this.idtconclusion=1;
        
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
        obtenerEspecialidad(){
            let me=this;
                var url=me.ruta + '/especialidad/selectEspecialidad';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayEspecialidad = respuesta.consultas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        obtenerTExpediente(){
            let me=this;
                var url=me.ruta + '/texpediente/selectTipoExpediente';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayTExpediente = respuesta.consultas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        obtenerEstado(){
            let me=this;
                var url=me.ruta + '/estado/selectEstado';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayEstado = respuesta.consultas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        obtenerTArchivo(){
            let me=this;
                var url=me.ruta + '/tarchivo/selectTipoArchivo';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayTArchivo = respuesta.consultas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        obtenerTConclusion(){
            let me=this;
                var url=me.ruta + '/tconclusion/selectTipoConclusion';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayTConclusion = respuesta.consultas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        obtenerLocal(){
            let me=this;
                var url=me.ruta + '/local/selectLocal';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayLocal = respuesta.consultas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        obtenerPProcesal(){
            let me=this;
                var url=me.ruta + '/pprocesal/selectParteProcesal';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayPProcesal = respuesta.consultas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        obtenerCPersona(){
            let me=this;
                var url=me.ruta + '/cpersona/selectClasePersona';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayCPersona = respuesta.consultas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        obtenerMateria(){
            let me=this;
                var url=me.ruta + '/materia/selectMateria';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayMateria = respuesta.consultas;
                    
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
        obtenerNombrePProcesal(){
            let me=this;
            var arrayT=[];
            var url=me.ruta + '/pprocesal/obtenerNombre?id='+me.idpprocesal;       
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    arrayT = respuesta.consultas;
                    me.nom_pprocesal= arrayT[0].nombre;
                })
                .catch(function (error) {
                    console.log(error);
                   
                }); 
        },
        obtenerNombreCPersona(){
            let me=this;
            var arrayT=[];
            var url=me.ruta + '/cpersona/obtenerNombre?id='+me.idcpersona;       
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    arrayT = respuesta.consultas;
                    me.nom_cpersona= arrayT[0].nombre;
                })
                .catch(function (error) {
                    console.log(error);
                   
                }); 
        },
        obtenerNombreMateria(){
            let me=this;
            var arrayT=[];
            var url=me.ruta + '/materia/obtenerNombre?id='+me.idmateria;       
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    arrayT = respuesta.consultas;
                    me.nom_materia= arrayT[0].nombre;
                })
                .catch(function (error) {
                    console.log(error);
                   
                }); 
        },
        agregarDetalle(){
            let me=this; 
            if(this.validarDetalle1()){
                return;
            }
            else{
                me.arrayDetalle.push({
                    idpprocesal: me.idpprocesal,
                    idcpersona: me.idcpersona,
                    nom_pprocesal: me.nom_pprocesal,
                    nom_cpersona: me.nom_cpersona,
                    nombre: me.nombre,
                    apellido: me.apellido
                });
                me.idpprocesal=0;
                me.idcpersona=0;
                me.nom_pprocesal='';
                me.nom_cpersona='';
                me.nombre='';   
                me.apellido='';
            }  
        },
        agregarDetalle1(){
            let me=this; 
            if(this.validarDetalle2()){
                return;
            }
            else{
                me.arrayDetalle1.push({
                    idmateria: me.idmateria,
                    nom_materia: me.nom_materia
                    
                });
                me.idmateria=0;
                me.nom_materia='';
                
            }  
        },
        eliminarDetalle(index){
            let me = this;
            me.arrayDetalle.splice(index, 1);
        },
        eliminarDetalle1(index){
            let me = this;
            me.arrayDetalle1.splice(index, 1);
        },
        validarDetalle1(){
            this.errorDetalle=0;
                this.errorMostrarMsjDetalle =[];
                if (this.idpprocesal==0) this.errorMostrarMsjDetalle.push("Seleccione parte procesal");
                if (this.idcpersona==0) this.errorMostrarMsjDetalle.push("Seleccione clase persona");
                if (!this.apellido) this.errorMostrarMsjDetalle.push("Ingrese apellidos o razón social");
                if (!this.nombre) this.errorMostrarMsjDetalle.push("Ingrese nombre");
                if (this.errorMostrarMsjDetalle.length) this.errorDetalle = 1;
                return this.errorDetalle;
        },
        validarDetalle2(){
            this.errorDetalle1=0;
                this.errorMostrarMsjDetalle1 =[];
                if (this.idmateria==0) this.errorMostrarMsjDetalle1.push("Seleccione materia/delito");
               
                if (this.errorMostrarMsjDetalle1.length) this.errorDetalle1 = 1;
                return this.errorDetalle1;
        },
       
        generarCodigo23(){
            var cod=0;
            var a=10000000000000000000000;
            var b=99999999999999999999999;
            cod= Math.round(Math.random()*(b-a)+parseInt(a));
            var n = BigInt(cod);
            this.codigo_expediente=''+n;
            this.barcodeValue=''+n;
            //console.log(''+n);
        },
        validarRegistro(){
            this.errorRegistro=0;
            this.errorMostrarMsjRegistro=[];
            if(this.idingreso==0) this.errorMostrarMsjRegistro.push("Número de ingreso no válido");
            if(!this.codigo_expediente) this.errorMostrarMsjRegistro.push("Código de expediente no válido");
            if(!this.responsable) this.errorMostrarMsjRegistro.push("Ingrese un responsable de origen");
            if(this.idespecialidad==0) this.errorMostrarMsjRegistro.push("Seleccione especialidad");
            if(!this.numero_origen) this.errorMostrarMsjRegistro.push("Se requiere número de Exp origen");
            if(!this.anio_expediente) this.errorMostrarMsjRegistro.push("Se requiere año de Exp.");
            if(!this.numero_expediente) this.errorMostrarMsjRegistro.push("Se requiere número de Exp.");
            if(this.idtexpediente==0) this.errorMostrarMsjRegistro.push("Seleccione tipo Exp.");
            if(!this.folio){
                this.folio=0;
            }
            if(!this.cuaderno){
                this.cuaderno=0;
            } 
            if(this.idestado==0) this.errorMostrarMsjRegistro.push("Seleccione estado del Exp.");
            if(this.idestado==2) this.errorMostrarMsjRegistro.push("Estado incorrecto");
            if(this.idtarchivo==0) this.errorMostrarMsjRegistro.push("Seleccione tipo Archivo");
            if(!this.fecha_conclusion) this.errorMostrarMsjRegistro.push("Seleccione fecha de conclusión");
            if(this.idtconclusion==0) this.errorMostrarMsjRegistro.push("Seleccione tipo conclusión");
            if(!this.fecha_recepcion) this.errorMostrarMsjRegistro.push("Seleccione fecha de recepción");
            if(this.idlocal==0) this.errorMostrarMsjRegistro.push("Seleccione local");
            if(!this.anaquel){
                this.anaquel=0;
            }
            if(!this.paquete){
                this.paquete=0;
            }
           if(this.arrayDetalle.length==0){
                this.errorMostrarMsjRegistro.push("Se requiere las partes procesales");
            }else{
                this.validarProcesales();
            }
            
            if(this.arrayDetalle1.length==0){
                this.errorMostrarMsjRegistro.push("Se requiere materia/delito");
            }else{
                this.validarMateria();
            }
            
            if(this.errorMostrarMsjRegistro.length) this.errorRegistro=1;
            return this.errorRegistro;
        },

        // METODOS PARA REGISTRAR
        validarProcesales(){
            let me = this;
            var total=me.arrayDetalle.length;
            var ddte=0;
            var ddo=0;
            if(me.listado==0){
                if(me.arrayDetalle.length>0){
                    for(var i=0;i<total;i++){
                        var num=me.arrayDetalle[i].idpprocesal
                        if(num==1){
                            ddo++;
                        }else{
                            ddte++;
                        }
                    }
                }
                if(ddte==0){
               
                    me.arrayDetalle.push({
                    idpprocesal: 2,
                    idcpersona: 2,
                    nom_pprocesal: 'Demandante',
                    nom_cpersona: 'Persona Jurídica',
                    nombre: 'Ancash',
                    apellido: 'Corte Superior de Justicia'
                    });
                    me.idpprocesal=0;
                    me.idcpersona=0;
                    me.nom_pprocesal='';
                    me.nom_cpersona='';
                    me.nombre='';   
                    me.apellido='';
                
                }
                if(ddo==0){
                    me.errorMostrarMsjRegistro.push("Se requiere almenos un Demandado"); 
                }
            }else{
               if(me.arrayDetalle.length>0){
                    for(var i=0;i<total;i++){
                        var condi=me.arrayDetalle[i].condicion
                        if(condi==1){
                            var num=me.arrayDetalle[i].idpprocesal
                            if(num==1){
                                ddo++;
                            }else{
                                ddte++;
                            }
                        }
                        
                    }

                } 
                if(ddte==0){
                    me.errorMostrarMsjRegistro.push("Se requiere almenos un Demandante"); 
                }
                if(ddo==0){
                    me.errorMostrarMsjRegistro.push("Se requiere almenos un Demandado"); 
                }
            }
            
        },
        validarMateria(){
            let me = this;
            var total=me.arrayDetalle1.length;
            var cantidad=0;
            if(me.listado==2){
                if(me.arrayDetalle1.length>0){
                for(var i=0;i<total;i++){
                    var condi=me.arrayDetalle1[i].condicion
                    if(condi==1){
                        cantidad++; 
                    }
                    
                }

            } 
            if(cantidad==0){
                me.errorMostrarMsjRegistro.push("Se requiere almenos un Delito/Materia"); 
            }
            }
            
        },
        registrarRegistro(){
            let me=this;
            var num=0;
            if(this.validarRegistro()){
                return;
            }
            axios.post(me.ruta + '/expediente/registrar',{
                'idingreso': this.idingreso,
                'codigo': this.codigo_expediente,
                'responsable': this.responsable,
                'idespecialidad': this.idespecialidad,
                'numero_origen': this.numero_origen,
                'anio_expediente': this.anio_expediente,
                'numero_expediente': this.numero_expediente,
                'idtexpediente': this.idtexpediente,
                'folio': this.folio,
                'cuaderno': this.cuaderno,
                'idestado': this.idestado,
                'idtarchivo': this.idtarchivo,
                'fecha_conclusion': this.fecha_conclusion,
                'idtconclusion': this.idtconclusion,
                'fecha_recepcion': this.fecha_recepcion,
                'idlocal': this.idlocal,
                'anaquel': this.anaquel,
                'paquete': this.paquete,
                'observacion': this.observacion,
                'idusuario': this.idusuario,
                'data1': this.arrayDetalle,
                'data2': this.arrayDetalle1
               
                
            }).then(function(response){
               num=me.numero_ingreso;
                //me.totales(num);
                //INICIO DE TOTALES 
                var arrayT=[];
                var arrayT1=[];
                var t1=0;
                var t2=0;
                var t3=0;
                var url=me.ruta + '/ingreso/obtenerCantidadExpediente?numero='+num;    
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    arrayT = respuesta.consulta;
                    t1 = arrayT[0]['cantidad'];
                    
                    var url1=me.ruta + '/expediente/obtenerExpedienteIngresado?numero='+num;    
                    axios.get(url1).then(function (response) {
                    var respuesta=response.data;
                    arrayT1 = respuesta.consulta;
                    t2 = arrayT1[0]['ingresados'];
                    t3=parseInt(t1)-parseInt(t2);
                    me.total_expediente=t1;
                    me.ingresado_expediente=t2;
                    me.ingresado_pendiente=t3;
                    //APARTADO
                    
                    
                   
                    // FIN APARTADO
                    })
                    
                    .catch(function (error) {
                        console.log(error);
                    });

                })
                .catch(function (error) {
                    console.log(error);
                });
                // FIN TOTALES
                 Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Registro con Éxito',
                showConfirmButton: false,
                timer: 1500
                })
                me.listado=1;
                me.listarConsulta('','numero_expediente',num);
                me.limpiarCampo();

            }).catch(function(error){
                console.log(error);
            });
        },
        abrirCombos(){
            this.obtenerEspecialidad();
            this.obtenerTExpediente();
            this.obtenerEstado();
            this.obtenerTArchivo();
            this.obtenerTConclusion();
            this.obtenerLocal();
            this.obtenerPProcesal();
            this.obtenerCPersona();
            this.obtenerMateria();
        },
        //METODOS PARA ACTUALIZAR FORMULARIO
        abrirCombos(){
            this.obtenerEspecialidad();
            this.obtenerTExpediente();
            this.obtenerEstado();
            this.obtenerTArchivo();
            this.obtenerTConclusion();
            this.obtenerLocal();
            this.obtenerPProcesal();
            this.obtenerCPersona();
            this.obtenerMateria();
        },
         abrirActualizar(id){
            let me=this;
            me.listado=2;
           //me.obtenerDetalle(id);
            
            //Obtener los datos del requerimiento
            var arraySolicitudT1=[];
            var url=me.ruta + '/expediente/obtenerCabecera?id=' + id;
                
            axios.get(url).then(function (response) {
                var respuesta= response.data;
                arraySolicitudT1 = respuesta.consulta;
                me.abrirCombos();
                me.seleccion_id =arraySolicitudT1[0]['id'];
                me.codigo_expediente=arraySolicitudT1[0]['codigo'];
                me.distrito=arraySolicitudT1[0]['distrito'];
                me.provincia=arraySolicitudT1[0]['provincia'];
                me.organo=arraySolicitudT1[0]['organo'];
                me.instancia=arraySolicitudT1[0]['instancia'];
                me.direccion=arraySolicitudT1[0]['direccion'];
                me.responsable=arraySolicitudT1[0]['responsable'];
                me.idespecialidad=arraySolicitudT1[0]['idespecialidad'];
                me.numero_origen=arraySolicitudT1[0]['numero_origen'];
                me.anio_expediente=arraySolicitudT1[0]['anio_expediente'];
                me.numero_expediente=arraySolicitudT1[0]['numero_expediente'];
                me.idtexpediente=arraySolicitudT1[0]['idtexpediente'];
                me.folio=arraySolicitudT1[0]['numero_folio'];
                me.cuaderno=arraySolicitudT1[0]['numero_cuaderno'];
                me.idestado=arraySolicitudT1[0]['idestado'];
                me.idtarchivo=arraySolicitudT1[0]['idtarchivo'];
                me.fecha_conclusion=arraySolicitudT1[0]['fecha_conclusion'];
                me.idtconclusion=arraySolicitudT1[0]['idtconclusion'];
                me.fecha_recepcion=arraySolicitudT1[0]['fecha_recepcion'];
                me.idlocal=arraySolicitudT1[0]['idlocal'];
                me.anaquel=arraySolicitudT1[0]['anaquel'];
                me.paquete=arraySolicitudT1[0]['paquete'];
                me.observacion=arraySolicitudT1[0]['observacion'];
                me.obtenerDetalle1(me.seleccion_id);
                me.obtenerDetalle2(me.seleccion_id);
                
  
            })
            .catch(function (error) {
                console.log(error);
            }); 
             
        },
        obtenerDetalle1(id){
           let me=this;
                var url=me.ruta + '/expediente/obtenerDetalle1?id='+id;
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayDetalle = respuesta.consulta;
                    
                })
                .catch(function (error) {
                    console.log(error);
            });
        },
        obtenerDetalle2(id){
           let me=this;
                var url=me.ruta + '/expediente/obtenerDetalle2?id='+id;
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayDetalle1 = respuesta.consulta;
                    
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
            axios.put(me.ruta + '/expediente/actualizar',{
                'responsable': this.responsable,
                'idespecialidad': this.idespecialidad,
                'numero_origen': this.numero_origen,
                'anio_expediente': this.anio_expediente,
                'numero_expediente': this.numero_expediente,
                'idtexpediente': this.idtexpediente,
                'folio': this.folio,
                'cuaderno': this.cuaderno,
                'idestado': this.idestado,
                'idtarchivo': this.idtarchivo,
                'fecha_conclusion': this.fecha_conclusion,
                'idtconclusion': this.idtconclusion,
                'fecha_recepcion': this.fecha_recepcion,
                'idlocal': this.idlocal,
                'anaquel': this.anaquel,
                'paquete': this.paquete,
                'observacion': this.observacion,
                'idusuario': this.idusuario,
                'id': this.seleccion_id
                
            }).then(function(response){
                console.log(response.data);
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
                me.listarConsulta('','numero_expediente',num);
               
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
                axios.post(me.ruta + '/expediente/registrarDetalle',{
                    'idexpediente': me.seleccion_id,
                    'idpprocesal': me.idpprocesal,
                    'concepto': me.concepto,
                    'idcpersona': me.idcpersona,
                    'apellido': me.apellido,
                    'nombre': me.nombre

                }).then(function(response){
                    Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Registro Actualizado',
                    showConfirmButton: false,
                    timer: 1500
                    })
                    me.concepto='';
                    me.unidad='';
                    me.obtenerDetalle1(me.seleccion_id); 
                
                }).catch(function(error){
                    console.log(error);
                }); 
            }
        },
        registrarDetalle1(){
            let me=this; 
            if(this.validarDetalle2()){
                return;
            }
            else{
                axios.post(me.ruta + '/expediente/registrarDetalle1',{
                    'idexpediente': me.seleccion_id,
                    'idmateria': me.idmateria
                    

                }).then(function(response){
                    Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Registro Actualizado',
                    showConfirmButton: false,
                    timer: 1500
                    })
                    me.concepto='';
                    me.unidad='';
                    me.obtenerDetalle2(me.seleccion_id); 
                
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
                        axios.put(me.ruta + '/expediente/activarDetalle',{
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
                        axios.put(me.ruta + '/expediente/desactivarDetalle',{
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
        activarDetalle1(id){
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
                        axios.put(me.ruta + '/expediente/activarDetalle1',{
                            'id': id
                           
                        }).then(function(response){
                            var idcuenta=me.seleccion_id;
                            me.obtenerDetalle2(idcuenta);
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
        desactivarDetalle1(id){
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
                        axios.put(me.ruta + '/expediente/desactivarDetalle1',{
                            'id': id
                           
                        }).then(function(response){
                            var idcuenta=me.seleccion_id;
                            me.obtenerDetalle2(idcuenta);
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
        //ANULAR REGISTROS
        
        validarAnulado(){
            this.errorAnulado=0;
                this.errorMostrarMsjAnulado =[];
                if (this.seleccion_id==0) this.errorMostrarMsjAnulado.push("Seleccione un registro");
                if (!this.estado_anulado) this.errorMostrarMsjAnulado.push("Ingrese un estado");
                if (!this.motivo_anulado) this.errorMostrarMsjAnulado.push("Ingrese un motivo");
                if (this.errorMostrarMsjAnulado.length) this.errorAnulado = 1;
                return this.errorAnulado;
        },
        registrarAnulado(){
            let me=this; 
            var num=0;
            if(this.validarAnulado()){
                return;
            }
            else{
                axios.post(me.ruta + '/expediente/registrarAnulado',{
                    'idexpediente': me.seleccion_id,
                    'estado': me.estado_anulado,
                    'motivo': me.motivo_anulado,
                    'idusuario': me.idusuario

                }).then(function(response){
                    me.estado_anulado='ANULADO';
                    me.motivo_anulado='';
                
                axios.put(me.ruta + '/expediente/desactivarRegistro',{
                    'id': me.seleccion_id
                    
                }).then(function(response){
                    var idcuenta=me.seleccion_id;
                    me.cerrarModal();
                    num=me.numero_ingreso;
                    me.listarConsulta('','numero_expediente',num);
                    me.totales(num);
                    Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Expediente anulado',
                    showConfirmButton: false,
                    timer: 1500
                    })
                    }).catch(function(error){
                    console.log(error);
                });




                }).catch(function(error){
                    console.log(error);
                }); 
            }
        },
        restaurarAnulado(){
            let me=this; 
            var num=0;
            if(this.validarAnulado()){
                return;
            }
            else{
                axios.post(me.ruta + '/expediente/registrarAnulado',{
                    'idexpediente': me.seleccion_id,
                    'estado': me.estado_anulado,
                    'motivo': me.motivo_anulado,
                    'idusuario': me.idusuario

                }).then(function(response){
                    me.estado_anulado='ANULADO';
                    me.motivo_anulado='';
                
                axios.put(me.ruta + '/expediente/activarRegistro',{
                    'id': me.seleccion_id
                    
                }).then(function(response){
                    var idcuenta=me.seleccion_id;
                    num=me.numero_ingreso;
                    me.cerrarModal();
                    me.listarConsulta('','numero_expediente',num);
                    me.totales(num);
                    Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Restauración con Éxito',
                    showConfirmButton: false,
                    timer: 1500
                    })
                }).catch(function(error){
                    console.log(error);
                });




                }).catch(function(error){
                    console.log(error);
                }); 
            }
        },
        estadoExpediente(id){
          let me=this;
            var arrayT=[];
            var est=0;
            var url= me.ruta + '/expediente/obtenerEstado?id='+id;       
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    arrayT = respuesta.consultas;
                    est= arrayT[0].condicion;
                    if(parseInt(est)==0){
                        me.abrirModal('modal','anular',id);
                    }else{
                        me.abrirModal('modal','restaurar',id);
                    }
                })
                .catch(function (error) {
                    console.log(error);
                   
                });   
        },
        abrirModal(modelo,accion,id){
            switch(modelo){
                case "modal":
                {
                    switch(accion){
                        case 'anular':
                            {
                                this.modal=1;
                                this.tituloModal='Anular',
                                this.seleccion_id=id;
                                this.estado_anulado='ANULADO';
                                this.motivo_anulado='';
                                this.tipoAccion=1;
                                break;
                            }
                        case 'restaurar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Restaurar';
                                this.tipoAccion=2;
                                this.seleccion_id=id;
                                this.estado_anulado='RESTAURADO';
                                this.motivo_anulado='';
                               
                                break;
                            }
                    }
                }
            }
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.estado_anulado='';
            this.motivo_anulado='';
            
            
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
            if ((keyCode<32 || (keyCode>32 && keyCode < 65))  || (keyCode > 90 && keyCode < 97) || (keyCode > 122 &&  keyCode<164))  { 
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
            this.existe1=0;
        },
       
        limpiarCampo(){
            let me = this;
            me.titulo='';
            me.errorRegistro=0;
            me.errorMostrarMsjRegistro=[];

            me.codigo_expediente= '';
            me.distrito= '';
            me.provincia= '';
            me.organo= '';
            me.instancia= '';
            
            me.direccion= '';
            me.responsable= 'ODECMA';
            me.idespecialidad= 1;
            me.idtarchivo=1;
            //me.arrayEspecialidad= [];
            me.numero_origen= '';
            me.anio_expediente= '';
            me.numero_expediente= '';
            me.idtexpediente= 1;
            //me.arrayTExpediente= [];
            me.folio= 0;
            me.cuaderno= 0;
            me.idestado= 1;
            //me.arrayEstado= [];
            me.idtarchivo= 1;
            //me.arrayTArchivo= [];
            me.fecha_conclusion= '';
            me.idtconclusion= 1;
            //me.arrayTConclusion= [];

            me.fecha_recepcion= '';
            me.idlocal= 1;
            me.arrayLocal= [];
            me.anaquel= '';
            me.paquete= '';
            me.observacion= '';

            me.idpprocesal=0;
            me.idcpersona=0;

            me.errorDetalle=0;
            me.errorDetalle1=0;
            me.errorMostrarMsjDetalle=[];
            me.errorMostrarMsjDetalle1=[];
            me.arrayDetalle= [];
            me.arrayDetalle1= [];
           
        },
        reporte(){
            console.log('reporte');
            let me=this;
            var numero=me.numero_ingreso;
            if(!me.numero_ingreso){
                Swal.fire({
                    title: 'Error!',
                    text: 'No existen registros',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    })
            }else{
                if(me.arrayListado.length > 0){
                     numero = window.btoa(numero); 
                    window.open(me.ruta + '/reporte/paquete/sinVerificar/'+numero,'_blank');  
                }else{
                    Swal.fire({
                    title: 'Error!',
                    text: 'No existen registros',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    })
                }
               
            }
  
        }
        },
        mounted() {
           // this.listarConsulta(1,this.buscar,this.criterio);
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