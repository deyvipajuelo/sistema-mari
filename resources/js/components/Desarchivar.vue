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
                        <i class="fa fa-align-justify"></i> Desarchivar Expediente
                        <button type="button"  @click="abrirModal('modal','registrar')" v-if="idusuario==1 || idusuario==2" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <select class="form-control col-md-4" v-model="criterio">
                                            <option value="numero_expediente">Numero</option>
                                            <option value="anio_expediente">Año</option>
                                                
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarRegistro(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarRegistro(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>Del:</label>&nbsp;&nbsp;
                                        <input type="date" class="form-control" v-model="fecha_inicio" form="form_reporte" name="fecha_inicio">&nbsp;&nbsp;&nbsp;&nbsp;
                                        <label>Al:</label>&nbsp;&nbsp;
                                        <input type="date" class="form-control" v-model="fecha_fin" form="form_reporte" name="fecha_fin">&nbsp;&nbsp;
                                        <button type="submit" class="btn btn-success col-2" v-on:click="verReporte" form="form_reporte">
                                        <i class="fa fa-file-pdf-o"></i>
                                        </button>
                                        <form action="reporte/desarchivados" id="form_reporte" target="_blank">
                                        </form>
                                    </div>
                                </div>
                        </div>
                        <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Opción</th>
                                <th>N° Ingreso</th>
                                <th>Expediente</th>
                                <th>Materia/Delito</th>
                                <th>A</th>
                                <th>P</th>
                                <th>Motivo</th>
                                <th>Estado</th>
                                <th>Fecha</th>
                                <th>Oficio</th>
                            </tr>
                        </thead>
                        <tbody v-if="arrayListado.length">
                            <tr v-for="(registro,index) in listarRegistroPaginated" :key="index">
                            <td>
        
                                    <template v-if="registro.idestado==2">
                                        <button type="button" class="btn btn-success btn-sm" @click="archivarExpediente(registro.idedesarchivado,registro.idexpediente)">
                                        <i class="fa fa-check"></i></button>
                                    </template>
                                   
                                </td>
                                <td v-text="registro.numero_ingreso"></td>
                                <td v-text="registro.expediente"></td>                                  
                                <td ><textarea style="word-break: break-all;height: auto; resize: none;width:100%;font-size: 12px;font-family: monospace; " v-text="registro.parteprocesal" readonly>
                                    </textarea>
                                </td>
                                <td v-text="registro.anaquel"></td>
                                <td v-text="registro.paquete"></td>
                                 <td ><textarea style="word-break: break-all;height: auto; resize: none;width:100%;font-size: 12px;font-family: monospace; " v-text="registro.motivo" readonly>
                                    </textarea>
                                </td>
                                
                                <td>
                                    <span class="badge badge-danger">{{registro.estado}}</span>
                                </td>
                                <td v-text="registro.created_at"></td>
                                <td>
                                    <form action="reporte/getOficio" id="form_reporte_oficio" target="_blank">
                                        <input type="hidden" :value="registro.idexpediente" name="id_expediente"></input>
                                    </form>
                                    <button class="btn btn-success"><i class="fa fa-download" type="submit" form="form_reporte_oficio" v-on:click="verOficio"></i></button>
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
                <!-- /.card-body -->
                    <div class="card-footer clearfix">
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
                    </div>
                <!-- /.card-footer-->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
    <!-- INICIO MODAL -->
        <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" v-text="tituloModal"></h4>
                <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <span class="badge badge-info col-md-12">Buscar expediente</span>
                </div>
                <div class="form-group row">
                    
                    <label class="col-md-3 form-control-label" >Número</label>
                    <div class="col-md-3">
                        <input type="text" placeholder="N° Exp" class="form-control" v-model="numero_expediente" @keypress="soloNumero" maxlength="10" @keyup.enter="buscarExpediente">
                    </div>
                    <label class="col-md-2 form-control-label" >Año</label>
                    <div class="col-md-3">
                        <input type="text" placeholder="Año Exp" class="form-control" v-model="anio_expediente" @keypress="soloNumero" maxlength="4" @keyup.enter="buscarExpediente">
                    </div>
                    <button type="button" @click.prevent="buscarExpediente" class="btn btn-outline-info btn-sm">
                        <i class="fa fa-search"></i></button>
                    
                </div>
                <div v-show="errorModal" class="form-group row div-error">
                    <div class="text-center text-error">
                        <div v-for="error in errorMostrarMsjModal" :key="error" v-text="error">

                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <span class="badge badge-info col-md-12">Resultados</span>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 form-control-label">Condicion:</label>
                    <template v-if="condicion_buscar">
                        <template v-if="arrayExpediente.length==1">
                            <span class="badge badge-success col-md-9">{{arrayExpediente.length}}&nbsp;Exp. encontrado</span>
                        </template>
                        <template v-if="arrayExpediente.length>1">
                            <span class="badge badge-warning col-md-9">{{arrayExpediente.length}}&nbsp;Exp. encontrado</span>
                        </template>
                        <!--
                        &nbsp;
                        <button type="button" class="btn btn-outline-warning btn-sm">
                        <i class="fa fa-eye"></i></button>
                        -->
                    </template>
                    <template v-else>
                        <span class="badge badge-danger col-md-9">Exp. no existe</span>&nbsp;
                    </template>
                </div>
                 <div class="card-body table-responsive p-1" style="height:200px;">
                        <table class="table table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    
                                    <th>Opción</th>
                                    <th>N° Ingreso</th>
                                    <th>Expediente</th>
                                    <th>Materia/Delito</th>
                                    <th>Estado</th>
                                    
                                </tr>
                            </thead>
                            <tbody v-if="arrayExpediente.length">
                                <tr v-for="lista in arrayExpediente" :key="lista.id">
                                    <td>
                                      <input v-if="lista.idestado==1" type="radio" :value="lista.idexpediente" v-on:click="setDatos" v-model="picked" :data-anaquel="lista.anaquel" :data-paquete="lista.paquete" :data-demandado="(lista.parteprocesal.indexOf('DDO:') < lista.parteprocesal.indexOf('DTE:')) ? lista.parteprocesal.substring(lista.parteprocesal.indexOf('DDO:', 0) + 5, lista.parteprocesal.indexOf('DTE:', 0)) : lista.parteprocesal.substring(lista.parteprocesal.indexOf('DDO:', 0) + 5)">
                                      <input v-else type="radio" :value="lista.idexpediente"  disabled>
                                    </td>
                                    <td v-text="lista.numero_ingreso"></td>
                                    <td v-text="lista.expediente"></td>
                                   
                                    <td ><textarea style="word-break: break-all;height: auto; resize: none;width:100%;font-size: 12px;font-family: monospace; " v-text="lista.parteprocesal" readonly>
                                        </textarea>
                                    </td>
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
                                    <td colspan="5">
                                        No hay expedientes
                                    </td>
                                </tr>
                            </tbody>  
                        </table>
                    </div>
                <template v-if="condicion_buscar">
                <div class="form-group row">
                    <span class="badge badge-info col-md-12">Acción</span>
                </div>
                     <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <!-- <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Motivo</label>
                            <div class="col-md-9">
                                <textarea class="form-control" rows="3" placeholder="Ingrese motivo" v-model="motivo_expediente"></textarea>
                                
                            </div>
                        </div> -->
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Estado</label>
                            <div class="col-md-9">
                                <select class="form-control" v-model="idestado">
                                    <option value="0" disabled>Seleccione</option>
                                    <option v-for="estadoe in arrayEstado" :key="estadoe.id" :value="estadoe.id" v-text="estadoe.nombre"></option>
                                </select>
                            </div>
                        </div>
                        <div v-show="errorRegistro" class="form-group row div-error">
                            <div class="text-center text-error">
                                <div v-for="error in errorMostrarMsjRegistro" :key="error" v-text="error">

                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <span class="badge badge-info col-md-12">Datos para oficio</span>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Oficio N°</label>
                            <div class="col-md-9">
                                <input type="text" placeholder="Ingrese el numero de oficio" class="form-control" v-model="num_oficio">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Jefe</label>
                            <div class="col-md-9">
                                <input type="text" placeholder="Ingrese el nombre del Jefe de ODECMA" class="form-control" v-model="jefe">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Ref.:</label>
                            <div class="col-md-9">
                                <input type="text" placeholder="Ingrese la Ref." class="form-control" v-model="ref">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-3 form-control-label" for="text-input">Ingreso expediente:</label>
                            <div class="col-md-9">
                                <input type="text" placeholder="Ingrese el expediente" class="form-control" v-model="queja">
                            </div>
                        </div>
                    </form>
                </template>
               
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                <button type="button" v-if="tipoAccion==1 && condicion_buscar==1" class="btn btn-primary" @click="registrarRegistro()">Guardar</button>
                <button type="button" v-if="tipoAccion==2 && condicion_buscar==1" class="btn btn-primary" @click="actualizarRegistro()">Actualizar</button>
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
                arrayListado : [],
                pageNumber: 0,
                perPage: 5, //se define cantidad de registro por mostrar por hoja
                idresponsable: 0,
                idusuario: 0,
                arrayUsuario: [],
                fecha_sistema: '',
                fecha_completa: '',
                fecha_inicio: '',
                fecha_fin: '',
                // variables para busqueda de exp en mmodal
                arrayExpediente:[],
                errorModal: 0,
                errorMostrarMsjModal: [],
                //variables para modal
                numero_expediente:0,
                anio_expediente:0,
                estado_expediente:'Desarchivado',
                condicion_buscar:0,
                motivo_expediente:'',

                picked:0,
                idestado: 0,
                arrayEstado: [],

                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorRegistro: 0,
                errorMostrarMsjRegistro: [],
                
                criterio: 'numero_expediente',
                buscar: '',

                num_oficio: '',
                jefe: '',
                ref: '',
                queja: '',
                demandado: '',
                anaquel: '',
                paquete: ''
                
            }
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
            listarRegistro (buscar,criterio){
                let me=this;
                var url=this.ruta+'/desarchivar';
                axios.get(url,{
                params: {
                    'criterio' : criterio,
                    'buscar' : buscar,

                }
                }).then(function (response) {
                    me.inicializarPaginacion();
                    me.arrayListado=response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            verOficio(event){
                let formulario = event.target.closest("td").firstElementChild;
                formulario.submit();
            },
            verReporte (event){
                event.preventDefault();
                if (this.fecha_inicio !== '' && this.fecha_fin !== '') {
                    let formulario = document.getElementById('form_reporte');
                    formulario.submit();
                }
            },
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
            // metodos para modal
            cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.errorMostrarMsjModal.length=0;
            this.errorRegistro=0;
 
            },
            abrirModal(modelo,accion){
                
                switch(modelo){
                    case "modal":
                    {
                        switch(accion){
                            case 'registrar':
                                {
                                    this.modal=1;
                                    this.obtenerEstado();
                                    this.tituloModal='Desarchivar Expediente';
                                    var hoy = new Date();
                                    var fecha = hoy.getFullYear();
                                    this.anio_expediente=parseInt(fecha);
                                    this.tipoAccion=1;
                                    this.numero_expediente=0;
                                    this.picked=0;
                                    this.motivo_expediente='';
                                    this.idestado= 2;
                                    this.condicion_buscar=0;
                                    this.arrayExpediente.length=0;

                                    this.num_oficio='';
                                    this.jefe='';
                                    this.ref='';
                                    this.queja='';
                                    break;
                                }
                            case 'actualizar':
                                {
                                    //console.log(data);
                                    
                                    this.modal=1;
                                    this.tituloModal='Actualizar';
                                    this.tipoAccion=2;
                                    
                                    
                                    break;
                                }
                        }
                    }
                }
            },
            buscarExpediente(){
                let me=this; 
                if(this.validarBuscarModal()){
                    return;
                }
                else{
                    me.arrayExpediente.length=0;
                    var ani=me.anio_expediente;
                    var num=me.numero_expediente;
                    var url=me.ruta + '/consulta/consultaExpediente?anio='+ani+'&numero='+num;
                    axios.get(url).then(function (response) {
                        var respuesta=response.data;
                        me.arrayExpediente = respuesta.consulta;
                        if(me.arrayExpediente.length>0){
                            me.condicion_buscar=1;
                        }else{
                        me.condicion_buscar=0; 
                       me.condicion_buscar=0; 
                        me.condicion_buscar=0; 
                        }
                        
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
                }
            },
            validarBuscarModal(){
                this.errorModal=0;
                this.errorMostrarMsjModal =[];
                if (!this.numero_expediente) this.errorMostrarMsjModal.push("Ingrese número de exp.");
                if (!this.anio_expediente) this.errorMostrarMsjModal.push("Ingrese año de exp.");
                if (this.errorMostrarMsjModal.length) this.errorModal = 1;
                return this.errorModal;
            },
            validarRegistro(){
            this.errorRegistro=0;
            this.errorMostrarMsjRegistro=[];
            if(this.picked==0) this.errorMostrarMsjRegistro.push("Seleccione un expediente de la lista");
            // if(!this.motivo_expediente) this.errorMostrarMsjRegistro.push("Se requiere un motivo");
            if(!this.idestado) this.errorMostrarMsjRegistro.push("Seleccione un estado");
            if(this.idestado==1) this.errorMostrarMsjRegistro.push("Seleccione estado 'Desarchivado'");
            if(this.errorMostrarMsjRegistro.length) this.errorRegistro=1;

            return this.errorRegistro;
            },
            obtenerEstado(){
                let me=this;
                var url=me.ruta + '/estado/selectEstado';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    //console.log(respuesta.consultas);
                    me.arrayEstado = respuesta.consultas;
                   
                    
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
                axios.post(me.ruta + '/desarchivar/registrar',{
                    'idexpediente': this.picked,
                    'idestado': this.idestado,
                    'motivo': this.motivo_expediente,

                    'anaquel': this.anaquel,
                    'paquete': this.paquete,
                    'demandado': this.demandado,
                    'num_oficio': 'OFICIO N° ' + this.num_oficio + '-ac-USJ-GAD-CSJAN/PJ',
                    'jefe': this.jefe,
                    'ref': this.ref,
                    'queja': this.queja
 
                }).then(function(response){
                    me.actualizarExpediente();

                }).catch(function(error){
                    console.log(error);
                });
            },
            setDatos(event){

                this.anaquel = event.target.dataset.anaquel;
                this.paquete = event.target.dataset.paquete;
                this.demandado = event.target.dataset.demandado;
            },
            actualizarExpediente(){
                let me=this;
                axios.put(me.ruta + '/expediente/actualizarRegistro2',{
                'id': this.picked,
                'idestado': this.idestado
                
                }).then(function(response){
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Registro con Éxito',
                        showConfirmButton: false,
                        timer: 1500
                        })
                    me.cerrarModal();
                    me.listarRegistro('','numero_expediente');

                }).catch(function(error){
                    console.log(error);
                });
            },
            archivarExpediente(id,idexpediente){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Esta seguro de archivar el Exp.?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aceptar!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.isConfirmed) {
                        let me = this;
                        axios.put(me.ruta + '/desarchivar/actualizar',{
                            'id': id
                           
                        }).then(function(response){
                            me.picked=idexpediente;
                            me.idestado=1;
                            me.actualizarExpediente();
                             swalWithBootstrapButtons.fire(
                            'Activado!',
                            'El exp. ha sido archivado con éxito',
                            'success'
                            )
                            me.picked=0;
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
            //otros metodos
            soloNumero($event) {
            //console.log($event.keyCode); //keyCodes value
            let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
                if ((keyCode < 48 || keyCode > 57)) { // 46 is dot
                    $event.preventDefault(); 
                }
            },
            obtenerUsuario(){
            let me=this;
                var url=me.ruta + '/user/obtenerPersona/';
                axios.get(url).then(function (response) {
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
        },
        mounted() {
            this.obtenerUsuario();
            this.listarRegistro (this.buscar,this.criterio);
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