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
                    <i class="fa fa-align-justify"></i> Reporte de ingresossssss
                </div>
                <!-- LISTADO -->
            <template v-if="listado==1">
                <div class="card-body">
                    <div class="col-12 col-sm-12">
                        <div class="card card-primary card-outline card-tabs">
                            <div class="card-header p-0 pt-1 border-bottom-0">
                                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-three-fecha-tab" data-toggle="pill" href="#custom-tabs-three-fecha" role="tab" aria-controls="custom-tabs-three-fecha" aria-selected="true">Por rango de fechas</a>
                                </li>
                                
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="custom-tabs-three-tabContent">
                                <div class="tab-pane fade active show" id="custom-tabs-three-fecha" role="tabpanel" aria-labelledby="custom-tabs-three-fecha-tab">
                                    
                                    <div class="form-group row">
                                       
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <label>Del:</label>&nbsp;&nbsp;
                                                <input type="date" class="form-control" v-model="fecha_inicio">&nbsp;
                                                <label>Al:</label>&nbsp;&nbsp;
                                                <input type="date" class="form-control" v-model="fecha_fin">&nbsp;&nbsp;
                                                <label>Usuario:</label>&nbsp;&nbsp;
                                                <select>
                                                    <option v-for="item in array">{{ item }}</option>
                                                </select>
                                                <button type="submit" class="btn btn-default col-2" @click="buscarRegistro()">
                                                <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-6">
                                            <div class="input-group">
                                                <label>Total registros obtenidos:</label>&nbsp;&nbsp;
                                                <span v-text="totalRegistro"></span>&nbsp;&nbsp;
                                                <a href="#"  @click="validarModal('modal','resumen')">Ver resumen</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-show="errorRegistro" class="form-group row div-error">
                                        <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjRegistro" :key="error" v-text="error">

                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                                </div>
                            </div>
                        <!-- /.card --> 
                        </div>
                    </div>
                    
                    <div class="card-body table-responsive p-1">
                        <table class="table table-bordered text-nowrap">
                            <thead>
                                <tr>
                                    
                                    <th rowspan="2">Item</th>
                                    <th rowspan="2">Paquete</th>
                                    <th rowspan="2">Cod. Archivo</th>
                                    <th rowspan="2">Exp. Origen</th>
                                    <th rowspan="2">Instancias</th>
                                    <th rowspan="2">Especialidad</th>
                                    <th rowspan="2">Tipo</th>
                                    <th rowspan="2">Fech. Regist.</th>
                                    <th rowspan="2">Local</th>
                                    <th colspan="2">Ubicacion</th>
                                    
                                    
                                </tr>
                                <tr>
                                    <th>A</th>
                                    <th>P</th>
                                </tr>
                            </thead>
                            <tbody v-if="listarRegistroPaginated.length">
                                <tr v-for="(lista,index) in listarRegistroPaginated" :key="index">
                                    <td v-text="lista.contador"></td>
                                    <td v-text="lista.numero_ingreso"></td>
                                    <td v-text="lista.codigo"></td>
                                    <td v-text="lista.expediente"></td>
                                    <td v-text="lista.instancia"></td>
                                    <td v-text="lista.especialidad"></td>
                                    <td v-text="lista.tipoarchivo"></td>
                                    <td v-text="lista.fecha_registro"></td>
                                    <td v-text="lista.nombre_local"></td>
                                    <td v-text="lista.anaquel"></td>
                                    <td v-text="lista.paquete"></td>
                                    
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr>
                                    <td colspan="11">
                                        No hay registros
                                    </td>
                                </tr>
                            </tbody>  
                        </table>
                    </div>
                    
                </div>
                <div class="card-footer">
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
            </template>
                    <!-- FIN LISTADO -->
                    <!-- Registro -->
                
                    <!-- FIN REGISTRO -->
                    <!-- EDITAR -->
                
                    <!-- FIN EDITAR -->
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
            
    <!-- INICIO MODAL -->
   

     <!-- FIN MODAL -->
    <!-- INICIO MODAL -->
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
                <div class="table-responsive p-1 col-md-12"  style="height:380px !important;">
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Paquete</th>
                                <th>Total</th>
                                
                                
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="det1 in arrayResumen" :key="det1.id">
                               
                                <td v-text="det1.contador"></td>
                                <td v-text="det1.numero_ingreso"></td>
                                <td v-text="det1.total"></td>
                                
                                
                            </tr>
                        </tbody>
                        
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
 
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

     <!-- FIN MODAL -->
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

                fecha_inicio:'',
                fecha_fin:'',

                totalRegistro: 0,

                errorRegistro: 0,
                errorMostrarMsjRegistro: [],
                // apartado de paginacion nueva
                pageNumber: 0,
                perPage: 20, //se define cantidad de registro por mostrar por hoja

                //fin apartado
                //MODAL
                arrayResumen: [],
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                // FIN MODAL
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
            //METODOS PARA LISTAR REGISTRO
        listarConsulta(){
            let me=this;
            var url=me.ruta + '/consulta/ingresoPorFecha';
            axios.get(url,{
                params: {
                    'fecha_inicio': this.fecha_inicio,
                    'fecha_fin': this.fecha_fin
                }
            }).then(function (response) {
                //console.log(response.data);
                me.inicializarPaginacion();
                me.arrayListado=response.data.consulta;
                me.totalRegistro =me.arrayListado.length;
                //var respuesta=response.data;
               // me.arrayListado = respuesta.consultas.data;
               // me.pagination=respuesta.pagination;
                
                
            })
            .catch(function (error) {
                console.log(error);
            });
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

        // METODOS PARA OBTENER LISTADO

      
       
      
        // METODOS PARA BUSQUEDA
       buscarRegistro(){
            if(this.validarRegistro()){
                return;
            }else{
                let me=this;
                
                me.listarConsulta();
                
                //CONSULTA PARA OBTENER TOTAL DE REGISTROS, SIN USO POR AHORA
                var url=me.ruta + '/consulta/totalIngresoPorFecha';
                axios.get(url,{
                    params: {
                        'fecha_inicio': this.fecha_inicio,
                        'fecha_fin': this.fecha_fin
                    }
                }).then(function (response) {
                    var respuesta=response.data;
                    //me.totalRegistro =respuesta.consultas[0].total;
                    //me.listarConsulta();
                    //console.log(response.data);
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
                // FIN CONSULTA
 
            }

       },
        
        validarRegistro(){
            this.errorRegistro=0;
            this.errorMostrarMsjRegistro=[];
            if(!this.fecha_inicio) this.errorMostrarMsjRegistro.push("Seleccione fecha de inicio");
            if(!this.fecha_fin) this.errorMostrarMsjRegistro.push("Seleccione fecha fin");

            if(this.errorMostrarMsjRegistro.length) this.errorRegistro=1;
            return this.errorRegistro;
        },
        //ABRIR MODAL
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.nombre='';
            
        },
        validarModal(modelo,accion){
            if(this.arrayListado.length>0){
                let me=this;
                 var url=me.ruta + '/consulta/ingresoPorFechaResumen';
                axios.get(url,{
                    params: {
                        'fecha_inicio': this.fecha_inicio,
                        'fecha_fin': this.fecha_fin
                    }
                }).then(function (response) {
                    //var respuesta=response.data;
                    me.arrayResumen=response.data.consulta;
                    //me.totalRegistro =respuesta.consultas[0].total;
                    //me.listarConsulta();
                    //console.log(response.data);
                    //console.log(response.data);
                    me.abrirModal(modelo,accion)
                })
                .catch(function (error) {
                    console.log(error);
                });
                
            }else{
                Swal.fire({
                        title: 'Error!',
                        text: 'No hay registros',
                        icon: 'error',
                        confirmButtonText: 'OK'
                        }) 
            }
        }, 
         abrirModal(modelo,accion){
            switch(modelo){
                case "modal":
                {
                    switch(accion){
                        case 'resumen':
                            {
                                this.modal=1;
                                this.tituloModal='Resumen de ingresos',
                                
                               
                                this.tipoAccion=1;
                                break;
                            }
                       
                    }
                }
            }
        },
        
        //OTROS METODOS
        
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
                    me.fecha_inicio=me.fecha_sistema;
                    me.fecha_fin=me.fecha_sistema;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
       
        
       
        },
        mounted() {
           
            this.obtenerUsuario();
            //this.listarConsulta(1);

            

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