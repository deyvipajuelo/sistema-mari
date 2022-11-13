<template>
   <section class="content">
            <!-- Breadcrumb -->
        <ol class="breadcrumb">
        
            <li class="breadcrumb-item"><a href="main">Inicio</a></li>
            
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Búsqueda de expedientes 
                    <button type="button" @click="abrirModal('modal','buscar')" class="btn btn-info">
                        <i class="fa fa-search"></i>&nbsp;Buscar
                    </button>
                        
                    &nbsp;
                    <template v-if="botonreporte">
                    <button type="button" @click="reporte()" class="btn btn-warning">
                        <i class="fa fa-file-pdf-o"></i>&nbsp;Reporte
                    </button>  
                    </template>   
                </div>
                <!-- LISTADO -->
            <template v-if="listado==1">
                <div class="card-body">
                    
                    <div class="card-body table-responsive p-1">
                        <table class="table table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    
                                    <th>Opcion</th>
                                    <th>Código</th>
                                    <th>Expediente</th>
                                    <th>Tipo Exp.</th>
                                    <th>Instancia</th>
                                    <th>Materia/Delito</th>
                                    <th>Local</th>
                                    <th>A</th>
                                    <th>P</th>
                                    <th>Situación</th>
                                    
                                </tr>
                            </thead>
                            <tbody v-if="arrayListado.length">
                                        <tr v-for="lista in listarRegistroPaginated" :key="lista.id">
                                            <td>
                                                <template v-if="lista.condicion=='1' && lista.idestado==1">
                                                    <button type="button" @click="abrirActualizar(lista.id)" class="btn btn-warning btn-sm">
                                                    <i class="fa fa-eye"></i></button>
                                                
                                                    &nbsp;
                                                
                                                    <button type="button" class="btn btn-danger btn-sm" @click="abrirModal1('modal1','anular',lista.id)">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </template>
                                                <template v-else-if="lista.condicion=='0'">
                                                    <button type="button" class="btn btn-info btn-sm" @click="abrirModal1('modal1','restaurar',lista.id)">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                </template>
                                            </td>
                                            
                                            <td v-text="lista.codigo"></td>
                                            <td v-text="lista.expediente"></td>
                                            <td v-text="lista.tipoexpediente"></td>
                                            <td v-text="lista.instancia"></td>
                                            <td ><textarea style="word-break: break-all;height: auto; resize: none;width:100%;font-size: 12px;font-family: monospace; " v-text="lista.parteprocesal" readonly>
                                                </textarea>
                                            </td>
                                            <td v-text="lista.direccion"></td>
                                            <td v-text="lista.anaquel"></td>
                                            <td v-text="lista.paquete"></td>
                                            <td>
                                                <div v-if="lista.idestado==1">
                                                    <span class="badge badge-success">{{lista.estado}}</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">{{lista.estado}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="10">
                                                No hay expedientes
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
                
            </template>
            <!-- FIN REGISTRO -->
            <!-- EDITAR -->
            <template v-else-if="listado==2">
            <div class="card-body">
            <div class="form-group row border">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="text-input">Nro. Expediente del Sistema</label>
                        <input  type="text" v-model="numero_expediente1"   class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="text-input">Cod. Ingreso</label>
                        <input  type="text" v-model="numero_ingreso"   class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="text-input">Código Expediente</label>
                        <barcode v-bind:value="codigo_expediente" height="25">
                            Show this if the rendering fails.
                        </barcode>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="text-input">Exp. Origen</label>
                        <input  type="text" v-model="anio_expediente1"   class="form-control" readonly>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="text-input">Fech. Reg.</label>
                        <input  type="text" v-model="fecha_registro"   class="form-control" readonly>
                    </div>
                </div>
                
                
            </div>
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
                                <input  type="text" v-model="distrito"   class="form-control" placeholder="Distrito judicial" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="text-input">Provincia</label>
                                <input  type="text" v-model="provincia"   class="form-control" placeholder="Provincia" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="text-input">Organo Jurisdiccional</label>
                                <input  type="text" v-model="organo"   class="form-control" placeholder="Organo Jurisdiccional" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
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
            </div>
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Expediente</h3>
                    <div class="card-tools">
                    <a href="#form2" class="btn btn-tool" data-toggle="collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div id="form2" class="collapse card-body">
                    <div class="form-group row border">
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text-input">Especialidad</label>
                                <select class="form-control" v-model="idespecialidad">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="especialidad in arrayEspecialidad" :key="especialidad.id" :value="especialidad.id" v-text="especialidad.nombre"></option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4">
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
                                <label for="text-input">Cuadernos</label>
                                <input  type="text" v-model="cuaderno"   class="form-control" placeholder="Número de cuadernos">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="text-input">Folios</label>
                                <input  type="text" v-model="folio"   class="form-control" placeholder="Número de folios">
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text-input">Estado</label>
                                <select class="form-control" v-model="idestado">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="estadoe in arrayEstado" :key="estadoe.id" :value="estadoe.id" v-text="estadoe.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text-input">Tipo Archivo</label>
                                <select class="form-control" v-model="idtarchivo">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="tarchivo in arrayTArchivo" :key="tarchivo.id" :value="tarchivo.id" v-text="tarchivo.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="text-input">Fecha Conclusión</label>
                                <input  type="date" v-model="fecha_conclusion"   class="form-control" placeholder="Instancia" >
                            </div>
                        </div>
                        <div class="col-md-6" style="display: none">
                            <div class="form-group">
                                <label for="text-input">Tipo Conclusión</label>
                                <select class="form-control" v-model="idtconclusion">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="tconclusion in arrayTConclusion" :key="tconclusion.id" :value="tconclusion.id" v-text="tconclusion.nombre"></option>
                                </select>
                            </div>
                        </div>
                    
                    </div>
                </div>
            </div>
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Recepción</h3>
                    <div class="card-tools">
                    <a href="#form3" class="btn btn-tool" data-toggle="collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div id="form3" class="collapse card-body">
                    <div class="form-group row border">
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="text-input">Fecha recepción</label>
                                <input  type="date" v-model="fecha_recepcion"   class="form-control" >
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="text-input">Local</label>
                                <input  type="text" v-model="nom_local"   class="form-control" readonly>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="text-input">Anaquel</label>
                                <input  type="text" v-model="anaquel"   class="form-control" placeholder="Anaquel">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="text-input">Paquete</label>
                                <input  type="text" v-model="paquete"   class="form-control" placeholder="Paquete">
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
            </div>
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Partes Procesales</h3>
                    <div class="card-tools">
                    <a href="#form4" class="btn btn-tool" data-toggle="collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div id="form4" class="collapse card-body">
                    <div class="form-group row border">
                        <p class="col-md-12" style="background-color:#F97E2F;">(*Importante: Al agregar un registro o eliminar, la actualizacíon es directamente a la BD)</p>
                        <div class="col-md-2">
                            <div class="form-group">
                                    <label for="text-input">Part. proce.</label>
                                    <select class="form-control" v-model="idpprocesal1" @change="obtenerNombrePProcesal()">
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
            </div>
            <div class="card card-default">
                <div class="card-header">
                    <h3 class="card-title">Materia/Delito</h3>
                    <div class="card-tools">
                    <a href="#form5" class="btn btn-tool" data-toggle="collapse"><i class="fa fa-minus"></i></a>
                    </div>
                </div>
                <div id="form5" class="collapse card-body">
                    <div class="form-group row border">
                        <p class="col-md-12" style="background-color:#F97E2F;">(*Importante: Al agregar un registro o eliminar, la actualizacíon es directamente a la BD)</p>
                        <div class="col-md-10">
                            <div class="form-group">
                                    <label for="text-input">Materia Delito</label>
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
            <!-- OPCIONES DE BUSQUEDA -->
            <div class="modal-body">
              <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">          
                    <div class="form-group row">
                        <label class="col-md-2 form-control-label" for="text-input">Organo</label>
                        <div class="col-md-3">
                            <select class="form-control" v-model="idojudicial" @change='selectInstancia()'>
                                <option value="0">TODOS</option>
                                <option v-for="organo in arrayOrgano" :key="organo.id" :value="organo.id" v-text="organo.nombre"></option>
                            </select>
                            
                        </div>
                        <label class="col-md-3 form-control-label" for="text-input">Especialidad</label>
                        <div class="col-md-4">
                            <select class="form-control" v-model="idijudicial">
                                <option value="0">TODOS</option>
                                <option v-for="instancia in arrayInstancia" :key="instancia.id" :value="instancia.id" v-text="instancia.nombre"></option>
                            </select>
                            
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-4">
                            <button type="button" @click="selectBoton(1)" class="btn btn-warning">
                            <i class="fa fa-barcode"></i>&nbsp;Código y año
                            </button>     
                        </div>
                        <div class="col-md-5">
                            <button type="button" @click="selectBoton(2)" class="btn btn-info">
                            <i class="fa fa-users"></i>&nbsp;Partes Procesales
                            </button>     
                        </div>
                        <div class="col-md-3">
                            <button type="button" @click="selectBoton(3)" class="btn btn-success">
                            <i class="fa fa-globe"></i>&nbsp;Ubicación
                            </button>     
                        </div>
                    </div>
                    
                </form>
            </div>
            <!-- FIN OPCIONES DE BUSQUEDA -->
            <!-- CAMPOS DE BUSQUEDA -->
            <template v-if="mostrar==1">
                <div class="modal-body">
                    <form action="" method="get" enctype="multipart/form-data" class="form-horizontal">

                        <div class="form-group row">
                            <div class="col-md-6 custom-control custom-radio">
                                <input type="radio" id="radio1" name="grupo" @change="onChange($event)"  class="custom-control-input"  v-model="radio1" value="1">
                                <label class="custom-control-label" for="radio1">Código en Archivo/Paquete</label>
                            </div>
                            <template v-if="radio1">
                                <div class="col-md-6">
                                    <input  type="text" v-model="numero_paquete" class="form-control" @keypress="soloNumero" maxlength="10" @keyup.enter="buscarListado()"> 
                                </div>
                            </template>
                            <template v-else>
                                <div class="col-md-6">
                                    <input  type="text" v-model="numero_paquete" class="form-control" @keypress="soloNumero" maxlength="10" readonly> 
                                </div>
                            </template>
                            
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6 custom-control custom-radio">
                                <input type="radio" id="radio2" name="grupo" @change="onChange($event)" class="custom-control-input" v-model="radio2" value="2">
                                <label class="custom-control-label" for="radio2">Expediente Origen</label>
                            </div>
                            <template v-if="radio2">
                            <div class="col-md-3">
                                <input  type="text" v-model="anio_expediente" class="form-control" @keypress="soloNumero" maxlength="4" placeholder="Año"> 
                            </div>
                            <div class="col-md-3">
                                <input  type="text" v-model="numero_expediente" class="form-control" @keypress="soloNumero" placeholder="N° Exp" maxlength="10" @keyup.enter="buscarListado()"> 
                            </div>
                            </template>
                            <template v-else>
                                <div class="col-md-3">
                                    <input  type="text" v-model="anio_expediente" class="form-control" @keypress="soloNumero" maxlength="4" placeholder="Año" readonly> 
                                </div>
                                <div class="col-md-3">
                                    <input  type="text" v-model="numero_expediente" class="form-control" @keypress="soloNumero" placeholder="N° Exp" maxlength="10" readonly> 
                                </div>
                            </template>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4 custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox1" v-model="opcion1">
                                <label for="customCheckbox1" class="custom-control-label">Archivado</label>
                            </div>
                            <div class="col-md-4 custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox2" v-model="opcion2">
                                <label for="customCheckbox2" class="custom-control-label">Desarchivado</label>
                            </div>
                            <div class="col-md-4 custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox3" v-model="opcion3">
                                <label for="customCheckbox3" class="custom-control-label">Anulado</label>
                            </div>
                        </div>
                    
                        <div v-show="errorModal" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjModal" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>
                        <div class="form-group row" style="float:right;">
                            <button type="button" class="btn btn-primary" @click="buscarListado()" ><i class="fa fa-search"></i>&nbsp;Buscar</button>
                        </div>
                    </form>
                </div>
            </template>

            <template v-if="mostrar==2">
                <div class="modal-body">
                    <form action="" method="get" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-6 form-control-label" for="text-input">Parte</label>
                            <div class="col-md-6">
                                <select class="form-control" v-model="idpprocesal">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="procesal in arrayProcesal" :key="procesal.id" :value="procesal.id" v-text="procesal.nombre"></option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-6 form-control-label" for="text-input">Apellido/Razón Social</label>
                            <div class="col-md-6">
                                <input  type="text" v-model="apellido_buscar" class="form-control">
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-6 form-control-label" for="text-input">Nombre</label>
                            <div class="col-md-6">
                                <input  type="text" v-model="nom_buscar" class="form-control" @keyup.enter="buscarListado()">
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-4 custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox1" v-model="opcion1">
                                <label for="customCheckbox1" class="custom-control-label">Archivado</label>
                            </div>
                            <div class="col-md-4 custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox2" v-model="opcion2">
                                <label for="customCheckbox2" class="custom-control-label">Desarchivado</label>
                            </div>
                            <div class="col-md-4 custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox3" v-model="opcion3">
                                <label for="customCheckbox3" class="custom-control-label">Anulado</label>
                            </div>
                        </div>
                        <div v-show="errorModal" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjModal" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>
                        <div class="form-group row" style="float:right;">
                            <button type="button" class="btn btn-primary" @click="buscarListado()" ><i class="fa fa-search"></i>&nbsp;Buscar</button>
                        </div>            
                            
                    </form>
                </div>
            </template>
            
            <template v-if="mostrar==3">
                <div class="modal-body">
                    <form action="" method="get" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Local</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idlocal">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="local in arrayLocal" :key="local.id" :value="local.id" v-text="local.nombre"></option>
                                </select>
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Anaquel</label>
                            <div class="col-md-3" >
                                <input  type="text" v-model="numero_anaquel" class="form-control" @keypress="soloNumero" maxlength="5">
                            </div>
                            <label class="col-md-3 form-control-label" for="text-input">Paquete</label>
                            <div class="col-md-3" >
                                <input  type="text" v-model="numero_paquete" class="form-control" @keypress="soloNumero" maxlength="5" @keyup.enter="buscarListado()">
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col-md-4 custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox1"  v-model="opcion1">
                                <label for="customCheckbox1" class="custom-control-label">Archivado</label>
                            </div>
                            <div class="col-md-4 custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox2"  v-model="opcion2">
                                <label for="customCheckbox2" class="custom-control-label">Desarchivado</label>
                            </div>
                            <div class="col-md-4 custom-control custom-checkbox">
                                <input class="custom-control-input" type="checkbox" id="customCheckbox3"  v-model="opcion3">
                                <label for="customCheckbox3" class="custom-control-label">Anulado</label>
                            </div>
                        </div>
                        <div v-show="errorModal" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjModal" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>
                        <div class="form-group row" style="float:right;">
                            <button type="button" class="btn btn-primary" @click="buscarListado()"><i class="fa fa-search"></i>&nbsp;Buscar</button>
                        </div>                      
                            
                    </form>
                </div>
            </template>
            <!-- FIN CAMPOS DE BUSQUEDA -->
            <div class="modal-footer justify-content-right">
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

     <!-- FIN MODAL -->
    <!-- INICIO MODAL -->
    <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal1}" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-text="tituloModal1"></h4>
                            <button type="button" class="close" @click="cerrarModal1()" aria-label="Close">
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
                                <div v-show="errorAnulado1" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjAnulado1" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" @click="cerrarModal1()">Cerrar</button>
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

                errorModal: 0,
                errorMostrarMsjModal: [],
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,

                idojudicial: 0,
                arrayOrgano: [],
                idijudicial: 0,
                arrayInstancia: [],
                mostrar: 1,
                idpprocesal: 0,
                arrayProcesal: [],
                idlocal: 0,
                arrayLocal: [],

                radio1: true,
                radio2: false,
                opcion1: true,
                opcion2: true,
                opcion3: true,

                numero_paquete: '',
                anio_expediente: 0,
                numero_expediente: 0,
                
                numero_ingreso: '',
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
                anio_expediente1: '',
                numero_expediente1: '',
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
                fecha_registro: '',

                fecha_recepcion: '',
                idlocal1: 0,
                nom_local: '',
                arrayLocal1: [],
                anaquel: '',
                paquete: '',
                observacion: '',

                idpprocesal1: 0,
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

                nom_buscar: '',
                apellido_buscar: '',

                numero_anaquel: '',
                numero_paquete: '',
                numero_anaquel1: '',
                numero_paquete1: '',

                numero_paquete1: '',
                botonreporte: false,


                estado_anulado: '',
                motivo_anulado: '',
                modal1 : 0,
                tituloModal1 : '',
                tipoAccion1: 0,
                errorAnulado1: 0,
                errorMostrarMsjAnulado1: [],
                enlace: '',

                listado: 1,
                titulo: '',
                errorRegistro: 0,
                errorMostrarMsjRegistro: [],
                //paginacion
                pageNumber: 0,
                perPage: 20, //se define cantidad de registro por mostrar por hoja
                //fin paginacion
                criterio: 'numero_ingreso',
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
            //METODOS PARA LISTAR REGISTRO
        listarConsulta(url){
                let me=this;
                var url=url;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.inicializarPaginacion();
                    me.arrayListado = respuesta.consulta;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        

        // METODOS PARA ABRIR FORMULARIO CON DATOS NECESARIOS PARA REGISTRO

        abrirModal(modelo,accion){
            this.selectOrgano();
            this.obtenerProcesal();
            this.obtenerLocal();
            this.limpiarModal();
            
            switch(modelo){
                case "modal":
                {
                    switch(accion){
                        case 'buscar':
                            {
                                this.modal=1;
                                this.tituloModal='Buscar por:',
                                this.tipoAccion=1;
                                //this.mostrar=1;
                                this.numero_anaquel='';
                                this.numero_paquete='';
                                if(this.mostrar==1){
                                    this.radio1=true;
                                    this.radio2=false;
                                    this.idpprocesal=1;
                                    var hoy = new Date();
                                    var fecha = hoy.getFullYear();
                                    this.anio_expediente=parseInt(fecha);
                                    document.getElementById("radio1").checked = true;
                                }
                                
                                
                                break;
                            }
                        
                        
                    }
                }
            }
            
        },
        abrirModal1(modelo,accion,id){
            
            switch(modelo){
                case "modal1":
                {
                    switch(accion){
                        
                        case 'anular':
                            {
                                this.modal1=1;
                                this.tituloModal1='Anular',
                                this.seleccion_id=id;
                                this.estado_anulado='ANULADO';
                                this.motivo_anulado='';
                                this.tipoAccion1=1;
                                break;
                            }
                        case 'restaurar':
                            {
                                //console.log(data);
                                this.modal1=1;
                                this.tituloModal1='Restaurar';
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
            this.radio1=true;
            this.radio2=false;
            this.limpiarModal();
            //this.mostrar=1;
            
        },
        cerrarModal1(){
            this.modal1=0;
            this.tituloModal1='';
            this.estado_anulado='';
            this.motivo_anulado='';
            this.errorAnulado1=0;
            //this.mostrar=1;
            
        },
         validarAnulado(){
            this.errorAnulado1=0;
                this.errorMostrarMsjAnulado1 =[];
                if (this.seleccion_id==0) this.errorMostrarMsjAnulado1.push("Seleccione un registro");
                if (!this.estado_anulado) this.errorMostrarMsjAnulado1.push("Ingrese un estado");
                if (!this.motivo_anulado) this.errorMostrarMsjAnulado1.push("Ingrese un motivo");
                if (this.errorMostrarMsjAnulado1.length) this.errorAnulado1 = 1;
                return this.errorAnulado1;
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
                    me.cerrarModal1();
                    num=me.numero_ingreso;
                    me.listarConsulta(me.enlace);
                   
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
                    me.cerrarModal1();
                    me.listarConsulta(me.enlace);
                   
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
        selectOrgano(){
            let me=this;
            
                var url=me.ruta + '/ojudicial/selectOrganoJudicial';
                axios.get(url).then(function (response) {
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
            if(me.idojudicial==0){
                me.idijudicial=0;
                me.arrayInstancia.length=0;
            }else{
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
            }
                
        },
        obtenerProcesal(){
            let me=this;
                var url=me.ruta + '/pprocesal/selectParteProcesal';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayProcesal = respuesta.consultas;
                    
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
        validarModal(){
            this.errorModal=0;
            this.errorMostrarMsjModal=[];
            if(this.mostrar==1){
                if(this.radio1==false && this.radio2==false) this.errorMostrarMsjModal.push("Seleccione una opcion de búsqueda");
                if(this.radio1==true && !this.numero_paquete) this.errorMostrarMsjModal.push("Ingrese número de paquete");
                if(this.radio2==true && (!this.anio_expediente || !this.numero_expediente)) this.errorMostrarMsjModal.push("Ingrese año y número de expediente");
            }else{
                if(this.mostrar==2){
                   if(this.idpprocesal==0) this.errorMostrarMsjModal.push("Seleccione parte procesal"); 
                   if(!this.apellido_buscar) this.errorMostrarMsjModal.push("Ingrese apellido o Razón social"); 
                   if(!this.nom_buscar) this.errorMostrarMsjModal.push("Ingrese nombre");
                }else{
                    if(this.idlocal==0) this.errorMostrarMsjModal.push("Seleccione local"); 
                    if(!this.numero_anaquel) this.errorMostrarMsjModal.push("Ingrese anaquel"); 
                    if(!this.numero_paquete) this.errorMostrarMsjModal.push("Ingrese paquete");
                }
            }
            
           
            if(this.errorMostrarMsjModal.length) this.errorModal=1;

            return this.errorModal;
        },
        buscarListado(){
            let me=this; 
            if(this.validarModal()){
                return;
            }
            else{
                if(this.mostrar==1){
                    if(this.radio1==true){
                        
                        var num=me.numero_paquete;
                        var url=me.ruta + '/consulta/consultaPaquete?&numero='+num;
                        me.listarConsulta(url);
                        me.numero_paquete1=me.numero_paquete;
                        me.botonreporte=true;
                        me.mostrar==1;
                        me.cerrarModal();
                        
                        me.enlace=url;
                        me.numero_anaquel1='';
                        me.numero_paquete='';


                    }else{
                        if(this.radio2==true){
                            var ani=me.anio_expediente;
                            var num=me.numero_expediente;
                            var url=me.ruta + '/consulta/consultaExpediente?anio='+ani+'&numero='+num;
                            me.listarConsulta(url);
                            me.cerrarModal();
                            me.mostrar==1;
                            me.botonreporte=false;
                            me.numero_paquete1='';
                            me.enlace=url;
                            me.numero_anaquel1='';
                            me.numero_paquete='';
                        }
                    }
                    
                }else{
                    if(this.mostrar==2){
                        var id=me.idpprocesal;
                        var apellido=me.apellido_buscar;
                        var nombre =me.nom_buscar;
                        var url=me.ruta + '/consulta/consultaParteProcesal?idpprocesal='+id+'&apellido='+apellido+'&nombre='+nombre;
                        me.listarConsulta(url);
                        me.cerrarModal();
                        me.botonreporte=false;
                        me.mostrar==2;
                        me.numero_paquete1='';
                        me.enlace=url;
                        me.numero_anaquel1='';
                        me.numero_paquete='';
                    }else{
                        var id=me.idlocal;
                        var paquete=me.numero_paquete;
                        var anaquel =me.numero_anaquel;
                        var url=me.ruta + '/consulta/consultaAnaquel?idlocal='+id+'&anaquel='+anaquel+'&paquete='+paquete;
                        me.listarConsulta(url);
                        me.numero_anaquel1=anaquel;
                        me.numero_paquete1=paquete;
                        me.cerrarModal();
                        
                        me.botonreporte=true;
                        me.mostrar==3;
    
                        me.enlace=url;
                    }
                }
            }
            me.listado=1;
        },
        selectBoton(num){
            var valor=parseInt(num);
            if(valor==1){
                this.mostrar=1;
                this.radio1=false;
                this.radio2=false;
                this.limpiarModal();
                var hoy = new Date();
                var fecha = hoy.getFullYear();
                this.anio_expediente=parseInt(fecha);
                
            }else{
                if(valor==2){
                    
                    this.mostrar=2;
                    this.idpprocesal=1;
                    this.limpiarModal();
                   
                    
                }else{
                    
                    this.mostrar=3;
                    this.idlocal=1;
                    this.limpiarModal();
                    
                }
            }
            
            this.opcion1=true;
            this.opcion2=true;
            this.opcion3=true;

           
        },
        onChange(event) {
            var valor = event.target.value;
            if(valor==2){
                this.radio2=true;
                this.radio1=false;
            }else{
                this.radio1=true;
                this.radio2=false;
            }
              
              
          },
        activarCheckbox(){
            var num=parseInt(this.mostrar);
            if(num==1){
                document.getElementById('customRadio1').checked=true;
                document.getElementById("customCheckbox1").checked = true;
                document.getElementById("customCheckbox2").checked = true;
                document.getElementById("customCheckbox3").checked = true;  
            }else{
                if(num==2){
                    document.getElementById("customCheckbox1").checked = true;
                    document.getElementById("customCheckbox2").checked = true;
                    document.getElementById("customCheckbox3").checked = true;  
                }else{
                    document.getElementById("customCheckbox1").checked = true;
                    document.getElementById("customCheckbox2").checked = true;
                    document.getElementById("customCheckbox3").checked = true;  
                }
            }
        },
        // METODOS PARA REGISTRAR
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
            me.botonreporte=false;
            me.listado=2;
            var arraySolicitudT1=[];
            var url=me.ruta + '/expediente/obtenerCabecera?id=' + id;
            axios.get(url).then(function (response) {
                var respuesta= response.data;
                arraySolicitudT1 = respuesta.consulta;
                me.abrirCombos();
                me.seleccion_id =arraySolicitudT1[0]['id'];
                me.numero_ingreso=arraySolicitudT1[0]['numero_ingreso'];
                me.codigo_expediente=arraySolicitudT1[0]['codigo'];
                me.fecha_registro=arraySolicitudT1[0]['fecha_registro'];
                me.distrito=arraySolicitudT1[0]['distrito'];
                me.provincia=arraySolicitudT1[0]['provincia'];
                me.organo=arraySolicitudT1[0]['organo'];
                me.instancia=arraySolicitudT1[0]['instancia'];
                me.direccion=arraySolicitudT1[0]['direccion'];
                me.responsable=arraySolicitudT1[0]['responsable'];
                me.idespecialidad=arraySolicitudT1[0]['idespecialidad'];
                me.numero_origen=arraySolicitudT1[0]['numero_origen'];
                me.anio_expediente1=arraySolicitudT1[0]['expediente_origen'];
                me.numero_expediente1=arraySolicitudT1[0]['numero_sistema'];
                me.idtexpediente=arraySolicitudT1[0]['idtexpediente'];
                me.folio=arraySolicitudT1[0]['numero_folio'];
                me.cuaderno=arraySolicitudT1[0]['numero_cuaderno'];
                me.idestado=arraySolicitudT1[0]['idestado'];
                me.idtarchivo=arraySolicitudT1[0]['idtarchivo'];
                me.fecha_conclusion=arraySolicitudT1[0]['fecha_conclusion'];
                me.idtconclusion=arraySolicitudT1[0]['idtconclusion'];
                me.fecha_recepcion=arraySolicitudT1[0]['fecha_recepcion'];
                me.nom_local=arraySolicitudT1[0]['local1'];
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
        //METODOS PARA REGISTRAR ACTUALIZACION
        actualizarRegistro(){
            let me= this;
            var num=0;
            
            if(this.validarRegistro()){
                return;
            }
            axios.put(me.ruta + '/expediente/actualizar1',{
                'responsable': this.responsable,
                'idespecialidad': this.idespecialidad,
                'idtexpediente': this.idtexpediente,
                'folio': this.folio,
                'cuaderno': this.cuaderno,
                'idestado': this.idestado,
                'idtarchivo': this.idtarchivo,
                'fecha_conclusion': this.fecha_conclusion,
                'idtconclusion': this.idtconclusion,
                'fecha_recepcion': this.fecha_recepcion,
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
                if(me.mostrar==1 && me.numero_paquete1.length>0){
                     me.botonreporte=true;
                }else{
                    me.botonreporte=false;
                }
               
                me.limpiarCampo();
                //me.listarConsulta(num);
               
            }).catch(function(error){
                console.log(error);
            });
        },
        validarRegistro(){
            this.errorRegistro=0;
            this.errorMostrarMsjRegistro=[];
            if(this.seleccion_id==0) this.errorMostrarMsjRegistro.push("Vuelva a seleccionar el expediente");
            if(!this.responsable) this.errorMostrarMsjRegistro.push("Ingrese un responsable de origen");
            if(this.idespecialidad==0) this.errorMostrarMsjRegistro.push("Seleccione especialidad");
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
            if(!this.anaquel){
                this.anaquel=0;
            }
            if(!this.paquete){
                this.paquete=0;
            }
            if(this.arrayDetalle.length==0){
                this.errorMostrarMsjRegistro.push("Se requiere las partes procesales");
            } else{
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
        validarProcesales(){
            let me = this;
            var total=me.arrayDetalle.length;
            var ddte=0;
            var ddo=0;
            
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
        //OTROS METODOS
        ocultarDetalle(){
            this.listado=1;
            this.limpiarCampo();
            
        },
        asignarFocus(){
            this.$nextTick(() => {
                const editButtonRef = this.$refs.cantidad;
                editButtonRef.focus();
            });
        },
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
            if(this.mostrar==1 && this.numero_paquete1.length>0){
                this.botonreporte=true;
            }else{
                if(this.mostrar==3 && this.numero_anaquel1.length>0 && this.numero_paquete1.length>0 ){
                    this.botonreporte=true;
                }else{
                    this.botonreporte=false;
                }
                
            }
           
        },
        limpiarModal(){
            let me = this;
            me.titulo='';
            
            me.errorModal=0;
            me.errorMostrarMsjModal=[];
            me.anio_expediente=0;
            me.numero_expediente=0;
            me.apellido_buscar='';
            me.nom_buscar='';
            me.numero_anaquel='';
            me.numero_paquete='';
            

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
            me.responsable= '';
            me.idespecialidad= 0;
            //me.arrayEspecialidad= [];
            me.numero_origen= '';
            me.anio_expediente1= '';
            me.numero_expediente1= '';
            me.idtexpediente= 0;
            //me.arrayTExpediente= [];
            me.folio= 0;
            me.cuaderno= 0;
            me.idestado= 0;
            //me.arrayEstado= [];
            me.idtarchivo= 0;
            //me.arrayTArchivo= [];
            me.fecha_conclusion= '';
            me.idtconclusion= 0;
            //me.arrayTConclusion= [];

            me.fecha_recepcion= '';
            
            me.anaquel= '';
            me.paquete= '';
            me.observacion= '';

            me.errorDetalle=0;
            me.errorDetalle1=0;
            me.errorMostrarMsjDetalle=[];
            me.errorMostrarMsjDetalle1=[];
            me.arrayDetalle= [];
            me.arrayDetalle1= [];
           
        },
        reporte(){
            let me=this;
            if(me.mostrar==1){
                var numero=me.numero_paquete1;
                if(!me.numero_paquete1){
                    Swal.fire({
                        title: 'Error!',
                        text: 'No existen registros',
                        icon: 'error',
                        confirmButtonText: 'OK'
                        })
                }else{
                    if(me.arrayListado.length > 0){
                        numero = window.btoa(numero); 
                        window.open(me.ruta + '/reporte/paquete/'+numero,'_blank');  
                        
                    }else{
                        Swal.fire({
                        title: 'Error!',
                        text: 'No existen registros',
                        icon: 'error',
                        confirmButtonText: 'OK'
                        })
                    }
                
                }
            }else{
                if(me.mostrar==3){
                    if(me.arrayListado.length > 0){
                        var anaquel=me.numero_anaquel1
                        var paquete=me.numero_paquete1
                        anaquel = window.btoa(anaquel);
                        paquete = window.btoa(paquete); 
                        window.open(me.ruta + '/reporte/ubicacion/'+anaquel+'/'+paquete,'_blank');  
                        
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
            
  
        }
        },
        mounted() {
           // this.listarConsulta(1,this.buscar,this.criterio);
            this.obtenerUsuario();
            this.abrirModal('modal','buscar');

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