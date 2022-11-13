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
                        <i class="fa fa-align-justify"></i> Ingresos
                        
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Lista de Instancias</h3>
                                </div>
                                 <form>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Distrito Judicial</label>
                                            <select class="form-control" v-model="iddjudicial" @change='selectProvincia()'>
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="distrito in arrayDistrito" :key="distrito.id" :value="distrito.id" v-text="distrito.nombre"></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Provincia</label>
                                            <select class="form-control" v-model="idpjudicial" @change='selectOrgano()'>
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="provincia in arrayProvincia" :key="provincia.id" :value="provincia.id" v-text="provincia.nombre"></option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Organo Judicial</label>
                                            <select class="form-control" v-model="idojudicial" @click="listarInstancia()">
                                                <option value="0" disabled>Seleccione</option>
                                                <option v-for="organo in arrayOrgano" :key="organo.id" :value="organo.id" v-text="organo.nombre"></option>
                                            </select>
                                        </div>
                                        <!-- TABLA PARA MOSTRAR LAS INSTANCIAS -->
                                        <div class="card-body table-responsive p-0" style="height: 200px;">
                                            <table class="table table-bordered text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>Instancia</th>
                                                        <th>Opcion</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="arrayLista1.length">
                                                    <tr v-for="lista1 in arrayLista1" :key="lista1.id">
                                                         <td v-text="lista1.nombre"></td>
                                                         <td style="width:1px;">
                                                             <button type="button" @click="listarPaquete(1,buscar,criterio,anio,lista1)" class="btn btn-outline-info btn-sm">
                                                            <i class="fa fa-spinner fa-spin"></i></button>
                                                         </td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else>
                                                    <tr>
                                                        <td colspan="2">
                                                            No hay registros
                                                        </td>
                                                    </tr>
                                                </tbody>  
                                            </table>
                                        </div>
                                        <!-- FIN TABLA PARA MOSTRAR LAS INSTANCIAS -->
                                    </div> 
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card card-secondary">
                                <div class="card-header">
                                    <h3 class="card-title">Paquetes</h3>
                                </div>
                              
                                <div class="card-body">
                                    <div class="form-group row border">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="text-input">Fecha</label>
                                                <input  type="date"  v-model="fecha_inicio" class="form-control" @keyup.enter="listarPorFecha()">
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <select class="form-control col-md-4" v-model="criterio">
                                                    <option value="numero_ingreso">N° Ingreso</option>
                                                    <option value="verificado">Verificado</option> 
                                                    <option value="anulado">Anulado</option>  
                                                </select>
                                                <input type="text" v-model="buscar" @keyup.enter="listarConsulta(1,buscar,criterio,anio,instancia)" class="form-control" placeholder="Texto a buscar">
                                                <button type="submit" @click="listarConsulta(1,buscar,criterio,anio,instancia)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                                &nbsp;
                                                <button type="submit" @click="abrirModal('modal','registrar')" class="btn btn-success"><i class="fa fa-plus"></i> Nuevo</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body table-responsive p-0" style="height: 400px;">
                                    <table class="table table-bordered text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>Opciones</th>
                                                <th>Nro Ingreso</th>
                                                <th>Fecha</th>
                                                <th>Expedientes</th>
                                                <th>Recibido por</th>
                                                <th>Anulado</th>
                                                <th>Verificado</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayListado.length">
                                            <tr v-for="lista in arrayListado" :key="lista.id">
                                                <td>
                                                    <template v-if="lista.condicion=='1' && lista.verificado=='NO' && lista.anulado=='NO'">
                                                        <button @click="abrirModal('modal','actualizar',lista)"  type="button" class="btn btn-outline-warning btn-sm">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>  
                                                    </template>
                                                     &nbsp;
                                                     
                                                     <template v-if="lista.verificado=='NO' && lista.anulado=='NO'">
                                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivar(lista.id)">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </template>
                                                    <template v-else-if="lista.verificado=='NO' && lista.anulado=='SI'">
                                                        <button type="button" class="btn btn-info btn-sm" @click="activar(lista.id)">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </template>
                                                     &nbsp;
                                                    <template v-if="lista.condicion=='1' && lista.verificado=='SI' && lista.anulado=='NO'">
                                                        <button @click="abrirModal1('modal1','reubicar',lista.id,lista)"  type="button" class="btn btn-outline-info btn-sm">
                                                            <i class="fa fa-refresh"></i>
                                                        </button>  
                                                    </template> 

                                                </td>
                                                <td v-text="lista.numero_ingreso"></td>
                                                <td v-text="lista.fecha_ingreso"></td>
                                                <td v-text="lista.cantidad_expediente"></td>
                                                <td v-text="lista.usuario"></td>
                                                <td v-text="lista.anulado"></td>
                                                <td v-text="lista.verificado"></td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="7">
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
                                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page -1,buscar,criterio,anio,instancia)">Ant</a>
                                            </li>
                                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                                <a class="page-link" href="#"  @click.prevent="cambiarPagina(page,buscar,criterio,anio,instancia)" v-text="page"></a>
                                            </li>
                                                    
                                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page +1,buscar,criterio,anio,instancia)">Sig</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            
         <!-- INICIO MODAL -->
    <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog  modal-lg">
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
                            <label class="col-md-3 form-control" for="text-input">Código</label>
                            <div class="col-md-9">
                                
                                <input v-model="numero_ingreso" type="text"  class="form-control" readonly> 
                            </div>
                            <p class="col-md-12 form-control" style="text-align: justify; color:red;">El código mostrado es variable, podría ser un número posterior según la cantidad de usuarios que están generando paquetes</p>
                        </div>
                        <div class="form-group row border">
                            <h6 class="col-md-12 form-control-label" style="color: red;">Procedencia</h6>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text-input">Distrito Judicial</label>
                                    <input v-model="distrito" type="text"  class="form-control" readonly> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text-input">Provincia</label>
                                    <input v-model="provincia" type="text"  class="form-control" readonly> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text-input">Órgano Judicial</label>
                                    <input v-model="organo" type="text"  class="form-control" readonly> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Instancia</label>
                                    <input v-model="nombre_instancia" type="text"  class="form-control" readonly> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Dirección</label>
                                    <input v-model="direccion" type="text"  class="form-control" readonly> 
                                </div>
                            </div>
                           
                            <h6 class="col-md-12 form-control-label" style="color: red;">Datos de Ingreso</h6>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Local</label>
                                     <select class="form-control" v-model="idlocal">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="local in arrayLocal" :key="local.id" :value="local.id" v-text="local.nombre"></option>
                                       </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Fecha Ingreso</label>
                                    <input v-model="fecha_ingreso" type="text"  class="form-control" readonly> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text-input">Cantidad Expediente</label>
                                    <input v-model="cantidad_expediente" type="number" min="0" oninput="validity.valid||(value='');" ref="cantidad" class="form-control" > 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text-input">Expediente Digitados</label>
                                    <input v-model="expediente_digitado" type="number" min="0" oninput="validity.valid||(value='');"  class="form-control" readonly> 
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="text-input">Verificado</label>
                                    <input v-model="verificado" type="text"  class="form-control" readonly > 
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="text-input">Observación</label>
                                    <textarea v-model="observacion" type="text" class="form-control" rows="2" ref="observacion"></textarea>
                                    
                                </div>
                            </div>
                        </div>
                                

                                <div v-show="errorRegistro" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjRegistro" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="validarCodigo()">Guardar</button>
                <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarRegistro()">Actualizar</button>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Local</label>
                                    <div class="col-md-9">
                                       <select class="form-control" v-model="idlocal1">
                                        <option value="0" disabled>Seleccione</option>
                                        <option v-for="local in arrayLocal1" :key="local.id" :value="local.id" v-text="local.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                               <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Anaquel</label>
                                    <div class="col-md-9">
                                        <input  type="text" v-model="anaquel"   class="form-control" @keypress="soloNumero">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Paquete</label>
                                    <div class="col-md-9">
                                        <input  type="text" v-model="paquete" class="form-control" @keypress="soloNumero">
                                        
                                    </div>
                                </div>
                                <div v-show="errorUbicacion" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjUbicacion" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" @click="cerrarModal1()">Cerrar</button>
                <button type="button" v-if="tipoAccion1==1" class="btn btn-primary" @click="reUbicacion()">Aceptar</button>
                
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
                arrayDistrito: [],
                arrayProvincia: [],
                arrayOrgano: [],

                fecha_inicio: '',
                fecha_fin: '',
                
                numero_ingreso: '',
                numero_ingreso1: '',
                distrito: '',
                provincia: '',
                organo: '',
                nombre_instancia: '',
                direccion: '',
                fecha_ingreso: '',
                idlocal: 0,
                arrayLocal: [],
                cantidad_expediente: 0,
                expediente_digitado: 0,
                verificado: '',
                observacion: '',

                modal : 0,
                tituloModal : '',
                tipoAccion: 0,

                nuevoArray: [],
                modal1 : 0,
                tituloModal1 : '',
                tipoAccion1: 0,
                idlocal1: 0,
                arrayLocal1: [],
                anaquel: 0,
                paquete: 0,
                errorUbicacion: 0,
                errorMostrarMsjUbicacion: [],

                arrayLista1: [],
                instancia: 0,
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
                criterio: 'numero_ingreso',
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
        listarConsulta (page,buscar,criterio,anio){
                let me=this;
                
                var url=me.ruta + '/ingreso?page=' + page+'&buscar='+buscar+'&criterio='+criterio+'&anio='+anio+'&instancia='+this.instancia;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayListado = respuesta.consultas.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        listarConsulta2 (page,buscar,criterio){
                let me=this;
                var fecha=me.fecha_inicio
                var url=me.ruta + '/ingreso/lista?page=' + page+'&buscar='+buscar+'&criterio='+criterio+'&fecha='+fecha+'&instancia='+this.instancia;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayListado = respuesta.consultas.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        cambiarPagina(page,buscar,criterio,anio){
            let me = this;
            //actualiza la pagina actual
            me.pagination.current_page=page;
            // envia la peticion para visualizar la data de esa pagina
            me.listarConsulta(page,buscar,criterio,anio);

        },
        // METODOS PARA ABRIR FORMULARIO CON DATOS NECESARIOS PARA REGISTRO
        listarPaquete(page,buscar,criterio,anio,data=[]){
            let me=this;
            this.instancia=data['id'];
            me.listarConsulta (page,buscar,criterio,anio);
            me.fecha_inicio=me.fecha_sistema
        },
        listarPorFecha(){
            let me = this;
            me.listarConsulta2(1,'','');

        },
        listarInstancia(){
            let me=this;
                var url=me.ruta + '/ijudicial/comboInstanciaJudicial';
                axios.get(url,{
                    params: {
                        idojudicial: this.idojudicial
                 }
                 }).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayLista1 = respuesta.consultas;
                    
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
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
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.cantidad_expediente=0;
            this.expediente_digitado=0;
            this.verificado='NO';
            this.observacion='';
            this.numero_ingreso='';
            this.distrito='';
            this.provincia= '';
            this.organo='';
            this.nombre_instancia='';
            this.direccion='';
            this.idlocal=0;
            this.fecha_ingreso='';
           
            this.errorRegistro=0;   
        },
        obtenerInstanciaSeleccionado(){
           let me=this;
           var arrayT=[];
           var fecha2= this.fecha_sistema.substr(0,4);
                var url=me.ruta + '/ijudicial/obtenerProcedencia';
                axios.get(url,{
                    params: {
                        instancia: this.instancia
                 }
                 }).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    arrayT = respuesta.consultas;
                    me.distrito=arrayT[0]['distrito'];
                    me.provincia=arrayT[0]['provincia'];
                    me.organo=arrayT[0]['organo'];
                    me.nombre_instancia=arrayT[0]['instancia'];
                    me.direccion=arrayT[0]['local'];
                   
                  // total = arrayT[0]['total'];
                    
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
                    me.arrayLocal1 = respuesta.consultas;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        generarCodigo(){
           let me=this;
            var arrayT=[];
            var arrayT1=[];
            var total=0;
            var cod='';
            var numero=0;
            this.numero_ingreso='';
            //var fecha2= this.fecha_sistema.substr(0,4);
                var url=me.ruta + '/ingreso/obtenerTotal';
                axios.get(url).then(function (response) {
                   // console.log(response);
                   var respuesta=response.data;
                    arrayT = respuesta.consulta;
                   total = arrayT[0]['total']; 
                if(total>0){
                    var url1=me.ruta + '/ingreso/obtenerCodigo';
                        axios.get(url1).then(function (response) {
                            var respuesta1=response.data;
                            arrayT1 = respuesta1.consulta;
                            cod = arrayT1[0]['codigo'];
                            
                            numero=parseInt(cod);
                        if(numero<9){
                           me.numero_ingreso='000000000'+(numero+1); 
                           
                        }else{
                            if(numero>8 && numero<99){
                                me.numero_ingreso='00000000'+(numero+1);;
                                
                            }else{
                                if(numero>98 && numero<999){
                                    me.numero_ingreso='0000000'+(numero+1);
                                }else{
                                    if(numero>998 && numero<9999){
                                        me.numero_ingreso='000000'+(numero+1);
                                    }else{
                                        if(numero>9998 && numero<99999){
                                            me.numero_ingreso='00000'+(numero+1);
                                        }else{
                                            if(numero>99998 && numero<999999){
                                                me.numero_ingreso='0000'+(numero+1);
                                            }else{
                                                if(numero>999998 && numero<9999999){
                                                    me.numero_ingreso='000'+(numero+1);
                                                }else{
                                                    if(numero>9999998 && numero<99999999){
                                                        me.numero_ingreso='00'+(numero+1);
                                                    }else{
                                                        if(numero>99999998 && numero<999999999){
                                                            me.numero_ingreso='0'+(numero+1);
                                                        }else{
                                                            me.numero_ingreso=(numero+1);
                                                            
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                            
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }else{
                  me.numero_ingreso='0000000001';  
                } 
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        
        },
        validarCodigo(){
           let me=this;
            var arrayT=[];
            var arrayT1=[];
            var total=0;
            var cod='';
            var numero=0;
            //ESTO ES UNA PRUEBA
            var codigo_paquete='';
            this.numero_ingreso1='';
            //var fecha2= this.fecha_sistema.substr(0,4);
                var url=me.ruta + '/ingreso/obtenerTotal';
                axios.get(url).then(function (response) {
                   // console.log(response);
                   var respuesta=response.data;
                    arrayT = respuesta.consulta;
                   total = arrayT[0]['total']; 
                if(total>0){
                    var url1=me.ruta + '/ingreso/obtenerCodigo';
                        axios.get(url1).then(function (response) {
                            var respuesta1=response.data;
                            arrayT1 = respuesta1.consulta;
                            cod = arrayT1[0]['codigo'];
                            
                            numero=parseInt(cod);
                        if(numero<9){
                           me.numero_ingreso1='000000000'+(numero+1); 
                           //apartado
                           if(me.validarRegistro()){
                                return;
                            }
                            var anio=me.fecha_sistema.substr(0,4);
                            var n= me.numero_ingreso1;
                            axios.post(me.ruta + '/ingreso/registrar',{
                                'idijudicial': me.instancia,
                                'idlocal': me.idlocal,
                                'idusuario': me.idusuario,
                                'numero_ingreso':me.numero_ingreso1,
                                'cantidad_expediente':me.cantidad_expediente,
                                'fecha_ingreso':me.fecha_ingreso,
                                'expediente_digitado':me.expediente_digitado,
                                'verificado':me.verificado,
                                'observacion':me.observacion
                                
                            }).then(function(response){
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: 'Registro con Éxito con Código:'+n,
                                    showConfirmButton: false,
                                    timer: 1500
                                    })
                                me.cerrarModal();
                                
                                me.listarConsulta(1,'','numero_ingreso',anio);
                                //me.listarConsulta(1,'','numero_ingreso',anio);

                            }).catch(function(error){
                                console.log(error);
                            });

                            //fin apartado
                           
                        }else{
                            if(numero>8 && numero<99){
                                me.numero_ingreso1='00000000'+(numero+1);
                               //apartado
                                if(me.validarRegistro()){
                                        return;
                                    }
                                    var anio=me.fecha_sistema.substr(0,4);
                                    var n= me.numero_ingreso1;
                                    axios.post(me.ruta + '/ingreso/registrar',{
                                        'idijudicial': me.instancia,
                                        'idlocal': me.idlocal,
                                        'idusuario': me.idusuario,
                                        'numero_ingreso':me.numero_ingreso1,
                                        'cantidad_expediente':me.cantidad_expediente,
                                        'fecha_ingreso':me.fecha_ingreso,
                                        'expediente_digitado':me.expediente_digitado,
                                        'verificado':me.verificado,
                                        'observacion':me.observacion
                                        
                                    }).then(function(response){
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: 'Registro con Éxito con Código:'+n,
                                            showConfirmButton: false,
                                            timer: 1500
                                            })
                                        me.cerrarModal();
                                        
                                        me.listarConsulta(1,'','numero_ingreso',anio);
                                        //me.listarConsulta(1,'','numero_ingreso',anio);

                                    }).catch(function(error){
                                        console.log(error);
                                    });
                            
                            //fin apartado
                                
                            }else{
                                if(numero>98 && numero<999){
                                    me.numero_ingreso1='0000000'+(numero+1);
                                    //apartado
                                    if(me.validarRegistro()){
                                            return;
                                        }
                                        var anio=me.fecha_sistema.substr(0,4);
                                        var n= me.numero_ingreso1;
                                        axios.post(me.ruta + '/ingreso/registrar',{
                                            'idijudicial': me.instancia,
                                            'idlocal': me.idlocal,
                                            'idusuario': me.idusuario,
                                            'numero_ingreso':me.numero_ingreso1,
                                            'cantidad_expediente':me.cantidad_expediente,
                                            'fecha_ingreso':me.fecha_ingreso,
                                            'expediente_digitado':me.expediente_digitado,
                                            'verificado':me.verificado,
                                            'observacion':me.observacion
                                            
                                        }).then(function(response){
                                            Swal.fire({
                                                position: 'top-end',
                                                icon: 'success',
                                                title: 'Registro con Éxito con Código:'+n,
                                                showConfirmButton: false,
                                                timer: 1500
                                                })
                                            me.cerrarModal();
                                            
                                            me.listarConsulta(1,'','numero_ingreso',anio);
                                            //me.listarConsulta(1,'','numero_ingreso',anio);

                                        }).catch(function(error){
                                            console.log(error);
                                        });
                                
                                    //fin apartado
                                   
                                }else{
                                    if(numero>998 && numero<9999){
                                        me.numero_ingreso1='000000'+(numero+1);
                                        //apartado
                                        if(me.validarRegistro()){
                                                return;
                                            }
                                            var anio=me.fecha_sistema.substr(0,4);
                                            var n= me.numero_ingreso1;
                                            axios.post(me.ruta + '/ingreso/registrar',{
                                                'idijudicial': me.instancia,
                                                'idlocal': me.idlocal,
                                                'idusuario': me.idusuario,
                                                'numero_ingreso':me.numero_ingreso1,
                                                'cantidad_expediente':me.cantidad_expediente,
                                                'fecha_ingreso':me.fecha_ingreso,
                                                'expediente_digitado':me.expediente_digitado,
                                                'verificado':me.verificado,
                                                'observacion':me.observacion
                                                
                                            }).then(function(response){
                                                Swal.fire({
                                                    position: 'top-end',
                                                    icon: 'success',
                                                    title: 'Registro con Éxito con Código:'+n,
                                                    showConfirmButton: false,
                                                    timer: 1500
                                                    })
                                                me.cerrarModal();
                                                
                                                me.listarConsulta(1,'','numero_ingreso',anio);
                                                //me.listarConsulta(1,'','numero_ingreso',anio);

                                            }).catch(function(error){
                                                console.log(error);
                                            });
                                    
                                        //fin apartado
                                        
                                    }else{
                                        if(numero>9998 && numero<99999){
                                            me.numero_ingreso1='00000'+(numero+1);
                                            //apartado
                                            if(me.validarRegistro()){
                                                    return;
                                                }
                                                var anio=me.fecha_sistema.substr(0,4);
                                                var n= me.numero_ingreso1;
                                                axios.post(me.ruta + '/ingreso/registrar',{
                                                    'idijudicial': me.instancia,
                                                    'idlocal': me.idlocal,
                                                    'idusuario': me.idusuario,
                                                    'numero_ingreso':me.numero_ingreso1,
                                                    'cantidad_expediente':me.cantidad_expediente,
                                                    'fecha_ingreso':me.fecha_ingreso,
                                                    'expediente_digitado':me.expediente_digitado,
                                                    'verificado':me.verificado,
                                                    'observacion':me.observacion
                                                    
                                                }).then(function(response){
                                                    Swal.fire({
                                                        position: 'top-end',
                                                        icon: 'success',
                                                        title: 'Registro con Éxito con Código:'+n,
                                                        showConfirmButton: false,
                                                        timer: 1500
                                                        })
                                                    me.cerrarModal();
                                                    
                                                    me.listarConsulta(1,'','numero_ingreso',anio);
                                                    //me.listarConsulta(1,'','numero_ingreso',anio);

                                                }).catch(function(error){
                                                    console.log(error);
                                                });
                                        
                                            //fin apartado
                                                
                                        }else{
                                            if(numero>99998 && numero<999999){
                                                me.numero_ingreso1='0000'+(numero+1);
                                                //apartado
                                                if(me.validarRegistro()){
                                                        return;
                                                    }
                                                    var anio=me.fecha_sistema.substr(0,4);
                                                    var n= me.numero_ingreso1;
                                                    axios.post(me.ruta + '/ingreso/registrar',{
                                                        'idijudicial': me.instancia,
                                                        'idlocal': me.idlocal,
                                                        'idusuario': me.idusuario,
                                                        'numero_ingreso':me.numero_ingreso1,
                                                        'cantidad_expediente':me.cantidad_expediente,
                                                        'fecha_ingreso':me.fecha_ingreso,
                                                        'expediente_digitado':me.expediente_digitado,
                                                        'verificado':me.verificado,
                                                        'observacion':me.observacion
                                                        
                                                    }).then(function(response){
                                                        Swal.fire({
                                                            position: 'top-end',
                                                            icon: 'success',
                                                            title: 'Registro con Éxito con Código:'+n,
                                                            showConfirmButton: false,
                                                            timer: 1500
                                                            })
                                                        me.cerrarModal();
                                                        
                                                        me.listarConsulta(1,'','numero_ingreso',anio);
                                                        //me.listarConsulta(1,'','numero_ingreso',anio);

                                                    }).catch(function(error){
                                                        console.log(error);
                                                    });
                                            
                                                //fin apartado
                                                
                                            }else{
                                                if(numero>999998 && numero<9999999){
                                                    me.numero_ingreso1='000'+(numero+1);
                                                    //apartado
                                                    if(me.validarRegistro()){
                                                            return;
                                                        }
                                                        var anio=me.fecha_sistema.substr(0,4);
                                                        var n= me.numero_ingreso1;
                                                        axios.post(me.ruta + '/ingreso/registrar',{
                                                            'idijudicial': me.instancia,
                                                            'idlocal': me.idlocal,
                                                            'idusuario': me.idusuario,
                                                            'numero_ingreso':me.numero_ingreso1,
                                                            'cantidad_expediente':me.cantidad_expediente,
                                                            'fecha_ingreso':me.fecha_ingreso,
                                                            'expediente_digitado':me.expediente_digitado,
                                                            'verificado':me.verificado,
                                                            'observacion':me.observacion
                                                            
                                                        }).then(function(response){
                                                            Swal.fire({
                                                                position: 'top-end',
                                                                icon: 'success',
                                                                title: 'Registro con Éxito con Código:'+n,
                                                                showConfirmButton: false,
                                                                timer: 1500
                                                                })
                                                            me.cerrarModal();
                                                            
                                                            me.listarConsulta(1,'','numero_ingreso',anio);
                                                            //me.listarConsulta(1,'','numero_ingreso',anio);

                                                        }).catch(function(error){
                                                            console.log(error);
                                                        });
                                                
                                                    //fin apartado
                                                    
                                                }else{
                                                    if(numero>9999998 && numero<99999999){
                                                        me.numero_ingreso1='00'+(numero+1);
                                                        //apartado
                                                        if(me.validarRegistro()){
                                                                return;
                                                            }
                                                            var anio=me.fecha_sistema.substr(0,4);
                                                            var n= me.numero_ingreso1;
                                                            axios.post(me.ruta + '/ingreso/registrar',{
                                                                'idijudicial': me.instancia,
                                                                'idlocal': me.idlocal,
                                                                'idusuario': me.idusuario,
                                                                'numero_ingreso':me.numero_ingreso1,
                                                                'cantidad_expediente':me.cantidad_expediente,
                                                                'fecha_ingreso':me.fecha_ingreso,
                                                                'expediente_digitado':me.expediente_digitado,
                                                                'verificado':me.verificado,
                                                                'observacion':me.observacion
                                                                
                                                            }).then(function(response){
                                                                Swal.fire({
                                                                    position: 'top-end',
                                                                    icon: 'success',
                                                                    title: 'Registro con Éxito con Código:'+n,
                                                                    showConfirmButton: false,
                                                                    timer: 1500
                                                                    })
                                                                me.cerrarModal();
                                                                
                                                                me.listarConsulta(1,'','numero_ingreso',anio);
                                                                //me.listarConsulta(1,'','numero_ingreso',anio);

                                                            }).catch(function(error){
                                                                console.log(error);
                                                            });
                                                    
                                                        //fin apartado
                                                        
                                                    }else{
                                                        if(numero>99999998 && numero<999999999){
                                                            me.numero_ingreso1='0'+(numero+1);
                                                            //apartado
                                                            if(me.validarRegistro()){
                                                                    return;
                                                                }
                                                                var anio=me.fecha_sistema.substr(0,4);
                                                                var n= me.numero_ingreso1;
                                                                axios.post(me.ruta + '/ingreso/registrar',{
                                                                    'idijudicial': me.instancia,
                                                                    'idlocal': me.idlocal,
                                                                    'idusuario': me.idusuario,
                                                                    'numero_ingreso':me.numero_ingreso1,
                                                                    'cantidad_expediente':me.cantidad_expediente,
                                                                    'fecha_ingreso':me.fecha_ingreso,
                                                                    'expediente_digitado':me.expediente_digitado,
                                                                    'verificado':me.verificado,
                                                                    'observacion':me.observacion
                                                                    
                                                                }).then(function(response){
                                                                    Swal.fire({
                                                                        position: 'top-end',
                                                                        icon: 'success',
                                                                        title: 'Registro con Éxito con Código:'+n,
                                                                        showConfirmButton: false,
                                                                        timer: 1500
                                                                        })
                                                                    me.cerrarModal();
                                                                    
                                                                    me.listarConsulta(1,'','numero_ingreso',anio);
                                                                    //me.listarConsulta(1,'','numero_ingreso',anio);

                                                                }).catch(function(error){
                                                                    console.log(error);
                                                                });
                                                        
                                                            //fin apartado
                                                            
                                                        }else{
                                                            me.numero_ingreso1=(numero+1);
                                                            //apartado
                                                            if(me.validarRegistro()){
                                                                    return;
                                                                }
                                                                var anio=me.fecha_sistema.substr(0,4);
                                                                var n= me.numero_ingreso1;
                                                                axios.post(me.ruta + '/ingreso/registrar',{
                                                                    'idijudicial': me.instancia,
                                                                    'idlocal': me.idlocal,
                                                                    'idusuario': me.idusuario,
                                                                    'numero_ingreso':me.numero_ingreso1,
                                                                    'cantidad_expediente':me.cantidad_expediente,
                                                                    'fecha_ingreso':me.fecha_ingreso,
                                                                    'expediente_digitado':me.expediente_digitado,
                                                                    'verificado':me.verificado,
                                                                    'observacion':me.observacion
                                                                    
                                                                }).then(function(response){
                                                                    Swal.fire({
                                                                        position: 'top-end',
                                                                        icon: 'success',
                                                                        title: 'Registro con Éxito con Código:'+n,
                                                                        showConfirmButton: false,
                                                                        timer: 1500
                                                                        })
                                                                    me.cerrarModal();
                                                                    
                                                                    me.listarConsulta(1,'','numero_ingreso',anio);
                                                                    //me.listarConsulta(1,'','numero_ingreso',anio);

                                                                }).catch(function(error){
                                                                    console.log(error);
                                                                });
                                                        
                                                            //fin apartado
                                                            
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                           
                        }
                         
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                        
                }else{
                  me.numero_ingreso1='0000000001';  
                  //apartado
                    if(me.validarRegistro()){
                        return;
                    }
                    var anio=me.fecha_sistema.substr(0,4);
                    var n= me.numero_ingreso1;
                    axios.post(me.ruta + '/ingreso/registrar',{
                        'idijudicial': me.instancia,
                        'idlocal': me.idlocal,
                        'idusuario': me.idusuario,
                        'numero_ingreso':me.numero_ingreso1,
                        'cantidad_expediente':me.cantidad_expediente,
                        'fecha_ingreso':me.fecha_ingreso,
                        'expediente_digitado':me.expediente_digitado,
                        'verificado':me.verificado,
                        'observacion':me.observacion
                        
                    }).then(function(response){
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Registro con Éxito con Código:'+n,
                            showConfirmButton: false,
                            timer: 1500
                            })
                        me.cerrarModal();
                        
                        me.listarConsulta(1,'','numero_ingreso',anio);
                        //me.listarConsulta(1,'','numero_ingreso',anio);

                    }).catch(function(error){
                        console.log(error);
                    });

                            //fin apartado
                  
                } 

                
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
        
        abrirModal(modelo,accion,data=[]){
            if(this.instancia==0 || this.instancia==''){
                Swal.fire({
                    title: 'Error!',
                    text: 'Seleccione una instancia',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    })
            }else{

                switch(modelo){
                case "modal":
                {
                    switch(accion){
                        case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar',
                                this.obtenerInstanciaSeleccionado()
                                this.obtenerLocal();
                                this.generarCodigo();
                                this.asignarFocus();
                                this.idlocal=1;
                                this.fecha_ingreso=this.fecha_completa;
                                this.cantidad_expediente=0;
                                this.expediente_digitado=0;
                                this.verificado='NO';
                                this.observacion='';
                                
                                this.tipoAccion=1;
                                break;
                            }
                        case 'actualizar':
                            {
                                //console.log(data);
                                
                                this.modal=1;
                                this.tituloModal='Actualizar';
                                this.tipoAccion=2;
                                this.seleccion_id=data['id'];
                                this.numero_ingreso=data['numero_ingreso'];
                                this.idlocal=data['idlocal'];
                                this.fecha_ingreso=data['fecha_ingreso'];
                                this.cantidad_expediente=data['cantidad_expediente'];
                                this.expediente_digitado=data['expediente_digitado'];
                                this.verificado=data['verificado'];
                                this.observacion=data['observacion'];
                                this.obtenerInstanciaSeleccionado()
                                this.obtenerLocal();
                                
                                break;
                            }
                    }
                }
            }
            }
        },
        abrirModal1(modelo1,accion1,id,data=[]){
            switch(modelo1){
                case "modal1":
                {
                    switch(accion1){
                        case 'reubicar':
                            {
                                this.modal1=1;
                                this.obtenerLocal();
                                this.tituloModal1='Re-Ubicación',
                                this.seleccion_id=id;
                                this.idlocal1=data['idlocal'];
                                this.paquete=0;
                                this.anaquel=0;
                                this.tipoAccion1=1;
                                this.obtenerExpediente(id);
                                break;
                            }
                        
                    }
                }
            }
        },
        cerrarModal1(){
            this.modal1=0;
            this.tituloModal1='';
            this.paquete=0;
            this.anaquel=0;
            
        },
        obtenerExpediente(id){
            let me = this;
            var url=me.ruta + '/expediente/lista?id='+id;
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.nuevoArray = respuesta.consulta;
                   
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        registrarRegistro(){
            if(this.validarRegistro()){
                return;
            }

            let me = this;
            var anio=this.fecha_sistema.substr(0,4);
            
            
            axios.post(me.ruta + '/ingreso/registrar',{
                'idijudicial': this.instancia,
                'idlocal': this.idlocal,
                'idusuario': this.idusuario,
                'numero_ingreso':this.numero_ingreso,
                'cantidad_expediente':this.cantidad_expediente,
                'fecha_ingreso':this.fecha_ingreso,
                'expediente_digitado':this.expediente_digitado,
                'verificado':this.verificado,
                'observacion':this.observacion
                
            }).then(function(response){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Registro con Éxito con Código:'+n,
                    showConfirmButton: false,
                    timer: 1500
                    })
                me.cerrarModal();
                
                me.listarConsulta(1,'','numero_ingreso',anio);
                //me.listarConsulta(1,'','numero_ingreso',anio);

            }).catch(function(error){
                console.log(error);
            });

        },
        actualizarRegistro(){
            if(this.validarRegistro()){
                return;
            }

            let me = this;
            var anio=this.fecha_sistema.substr(0,4);
            axios.put(me.ruta + '/ingreso/actualizar',{
                'idlocal': this.idlocal,
                'cantidad_expediente': this.cantidad_expediente,
                'expediente_digitado': this.expediente_digitado,
                'observacion': this.observacion,
                
                'id': this.seleccion_id
                
            }).then(function(response){
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Actualización con Éxito',
                    showConfirmButton: false,
                    timer: 1500
                    })
                me.cerrarModal();
                me.listarConsulta(1,'','numero_ingreso',anio);
               
            }).catch(function(error){
                console.log(error);
            });
        },
         validarRegistro(){
            this.errorRegistro=0;
            this.errorMostrarMsjRegistro=[];
            if(this.idijudicial==0) this.errorMostrarMsjRegistro.push("Seleccione una instancia judicial");
            if(this.idlocal==0) this.errorMostrarMsjRegistro.push("Seleccione un local");
            if(this.idusuario==0) this.errorMostrarMsjRegistro.push("Error de usuario");
            if(!this.numero_ingreso) this.errorMostrarMsjRegistro.push("Se requiere un número de ingreso");
            if(!this.fecha_ingreso) this.errorMostrarMsjRegistro.push("Se requiere fecha de ingreso");
            if(!this.cantidad_expediente){
                this.errorMostrarMsjRegistro.push("Cantidad de expediente no puede estar vacio");
            }else{
                if(parseInt(this.cantidad_expediente)<1){
                    this.errorMostrarMsjRegistro.push("Cantidad de expediente tiene que ser mayor a 0");
                }
            } 
            if(!this.expediente_digitado){
                this.expediente_digitado=0;
            } else{
                if(parseInt(this.expediente_digitado)<0){
                    this.errorMostrarMsjRegistro.push("Expediente digitado no puede ser menor a 0");
                }
            }
            if(!this.verificado) this.errorMostrarMsjRegistro.push("Verificado no puede estar vacio");
            if(this.errorMostrarMsjRegistro.length) this.errorRegistro=1;

            return this.errorRegistro;
        },
        desactivar(id){
            let me= this;
            var arrayT=[];
            var c1=0;
            var url2=me.ruta + '/expediente/obtenerTotalId?id='+id;  
            axios.get(url2).then(function (response) {
                var respuesta=response.data;
                arrayT = respuesta.consulta;
                c1 = arrayT[0]['total'];
                if(parseInt(c1)==0){
                     var anio=me.fecha_sistema.substr(0,4);
                    
                    const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                        },
                        buttonsStyling: false
                        })

                        swalWithBootstrapButtons.fire({
                        title: 'Esta seguro de anular?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Aceptar!',
                        cancelButtonText: 'Cancelar',
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            
                            axios.put(me.ruta + '/ingreso/desactivar',{
                                'id': id
                            
                            }).then(function(response){
            
                               me.listarConsulta(1,'','nombre',anio);
                                swalWithBootstrapButtons.fire(
                                'Anulado!',
                                'El registro ha sido anulado con éxito',
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
                    }else{
                        Swal.fire('Paquete contiene almenos un expediente')
                    }

                })
                .catch(function (error) {
                    console.log(error);
                });

        },
        activar(id){
            let me= this;
            var anio=me.fecha_sistema.substr(0,4);
                    
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de restaurar?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        
                        axios.put(me.ruta + '/ingreso/activar',{
                            'id': id
                           
                        }).then(function(response){
        
                           me.listarConsulta(1,'','nombre',anio);
                             swalWithBootstrapButtons.fire(
                            'Restaurado!',
                            'El registro ha sido restaurado con éxito',
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
        //METODOS PARA REUBICACION
        reUbicacion(){
            let me=this;
           
            if(this.validarReUbicacion()){
                return;
            }
            axios.post(me.ruta + '/upaquete/registrar',{
                'idingreso': me.seleccion_id,
                'idlocal': me.idlocal1,
                'anaquel': me.anaquel,
                'paquete': me.paquete,
                'idusuario': me.idusuario
  
            }).then(function(response){
                me.actualizarExpediente();
                me.cerrarModal1();
                me.listado=1;
                
                me.listarConsulta2(1,'','');
               

            }).catch(function(error){
                console.log(error);
            });
        },
        validarReUbicacion(){
            this.errorUbicacion=0;
            this.errorMostrarMsjUbicacion=[];
            if(this.seleccion_id==0) this.errorMostrarMsjUbicacion.push("Número de ingreso incorrecto");
            if(this.idlocal1==0) this.errorMostrarMsjUbicacion.push("Seleccione un local");
            if(!this.anaquel || this.anaquel==0) this.errorMostrarMsjUbicacion.push("Ingrese anaquel");
            if(!this.paquete || this.paquete==0) this.errorMostrarMsjUbicacion.push("Ingrese paquete");
            if(this.errorMostrarMsjUbicacion.length) this.errorUbicacion=1;

            return this.errorUbicacion;
        },
        actualizarExpediente(){
            let me= this;
            var num=0;
            axios.put(me.ruta + '/expediente/actualizarRegistro',{
                'idlocal': this.idlocal1,
                'anaquel': this.anaquel,
                'paquete': this.paquete,
                'data': this.nuevoArray

            }).then(function(response){
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Reubicado',
                showConfirmButton: false,
                timer: 1500
                })
            }).catch(function(error){
                console.log(error);
            });
        },
        //OTROS METODOS
        soloNumero($event) {
        //console.log($event.keyCode); //keyCodes value
        let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57)) { // 46 is dot
                $event.preventDefault(); 
            }
        },
        longitudTexto(event,campo,long){
            if(campo.length==long){
               event.preventDefault();
               
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
           // this.limpiarCampo();
            
        },
       
        limpiarCampo(){
            let me = this;
            me.titulo='';
            me.errorRegistro=0;
            me.errorMostrarMsjRegistro=[];

           
        },
        
       
        },
        mounted() {
            this.listarConsulta(1,this.buscar,this.criterio);
            this.obtenerUsuario();
            this.selectDistrito();
            this.iddjudicial=1;
            this.selectProvincia();
            this.idpjudicial=1;
            this.selectOrgano();
           
           
           
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