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
                        <i class="fa fa-align-justify"></i> Verificación de Expedientes 
                        <div class="form-group row">
                            <div class="col-md-4">
                                <template v-if="botonActivo">
                                    <input  type="text" id="num_ingreso" name="num_ingreso" v-model="numero_ingreso" @keyup.enter="validarNumero(1,buscar,criterio,numero_ingreso)" @keypress="soloNumero" 
                                maxlength="10" class="form-control" placeholder="Número de ingreso">
                                </template>
                                <template v-else>
                                    <input  type="text" id="num_ingreso" name="num_ingreso" v-model="numero_ingreso" @keyup.enter="validarNumero(1,buscar,criterio,numero_ingreso)" @keypress="soloNumero" 
                                maxlength="10" class="form-control" placeholder="Número de ingreso" readonly>
                                </template>
                                
                            </div>
                            <label class="col-md-2 form-control-label" for="text-input">Total</label>
                            <div class="col-md-2">
                                <input  type="text" v-model="total_expediente" class="form-control" readonly>
                                
                            </div>
                            <label class="col-md-2 form-control-label" for="text-input">Digitados</label>
                            <div class="col-md-2">
                                <input  type="text" v-model="digitado_expediente" class="form-control" readonly>
                                
                            </div>

                            </div>
                            <div class="form-group row">
                            <label class="col-md-2 form-control-label" for="text-input">Por digitar</label>
                            <div class="col-md-2">
                                <input  type="text" v-model="falta_digitar" class="form-control" readonly>
                            </div>
                            <label class="col-md-2 form-control-label" for="text-input">Verificados</label>
                            <div class="col-md-2">
                                <input  type="text" v-model="verificado_expediente" class="form-control" readonly>
                            </div>
                            <label class="col-md-2 form-control-label" for="text-input">Faltan Verif.</label>
                            <div class="col-md-2">
                                <input  type="text" v-model="falta_verificar" class="form-control" readonly>
                            </div>
                        </div>
                        
                       
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                           
                           <div class="custom-control custom-checkbox">
                               <input class="custom-control-input" type="checkbox" id="customCheckbox1" v-model="checked" @click="seleccionarCheck()">
                               <template v-if="checked && botonActivo">
                                   <label for="customCheckbox1" class="custom-control-label">Deseleccionar todo</label>
                               </template>
                                <template v-else-if="checked==false && botonActivo">
                                   <label for="customCheckbox1" class="custom-control-label">Seleccionar todo</label>
                               </template>
                            </div>
                            <div class="col-md-3">
                                <template v-if="botonActivo">
                                    <button @click="asignarUbicacion()" class="btn btn-info form-control btnagregar">Asignar Ubicación</button>    
                                </template>
                                
                            </div>
                            <div class="col-md-3">
                                <button @click="verificarPaquete()" class="btn btn-warning form-control btnagregar"><i class="fa fa-check"></i>Verificar</button>    
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        
                                        <th>Aprobado</th>
                                        <th>Código Temp. Archivo</th>
                                        <th>Instancia</th>
                                        <th>Digitador</th>
                                        <th>Verificado</th>
                                        
                                    </tr>
                                </thead>
                               <tbody v-if="listarRegistroPaginated.length">
                                            <tr v-for="(lista,index) in listarRegistroPaginated" :key="index">
                                                <td>
                                                    <input class="custom-control" type="checkbox" v-model="checked1" disabled>
                                                </td>
                                               
                                                <td v-text="lista.codigo"></td>
                                                <td v-text="lista.instancia"></td>
                                                <td v-text="lista.usuario"></td>
                                                <td>
                                                    <div v-if="lista.verificado">
                                                        <span class="badge badge-success">SI</span>
                                                    </div>
                                                    <div v-else>
                                                        <span class="badge badge-danger">NO</span>
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
                    <template v-else-if="listado==0">
                      
                    </template>
                     <!-- FIN REGISTRO -->
                     <!-- EDITAR -->
                     <template v-else-if="listado==2">
                       
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
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUbicacion()">Aceptar</button>
                
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
                idingreso: 0,

                checked: false,
                checked1: false,
                nuevoArray: [],

                idlocal: 0,
                arrayLocal: [],
                anaquel: 0,
                paquete: 0,
                errorUbicacion: 0,
                errorMostrarMsjUbicacion: [],
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,

                total_expediente: 0,
                digitado_expediente: 0,
                falta_digitar: 0,
                verificado_expediente: 0,
                falta_verificar: 0,

                // apartado de paginacion nueva
                pageNumber: 0,
                perPage: 15, //se define cantidad de registro por mostrar por hoja

                //fin apartado
            
                botonActivo: true,
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
        listarConsulta(page,paquete){
                let me=this;
                
                var url=me.ruta + '/expediente/obtenerExpedienteSinVerificar?page=' + page+'&numero='+paquete;
                axios.get(url).then(function (response) {
                    /*
                    var respuesta=response.data;
                    me.arrayListado = respuesta.consultas.data;
                    me.pagination=respuesta.pagination;
                    */
                    me.inicializarPaginacion();
                    me.arrayListado=response.data.consulta;
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
                if(this.botonActivo){
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
                       me.listarConsulta(1,num);
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
                        title: 'Número de ingreso no existe',
                        showConfirmButton: false,
                        timer: 2000
                        })
                   }
                })
                .catch(function (error) {
                    console.log(error);
                });
                }else{
                    Swal.fire({
                    title: 'Error!',
                    text: 'Termine con la verificación para continuar',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    })
                }
            }
        },
        totales(num){
            let me=this;
            var arrayT=[];
            var arrayT1=[];
            var t1=0;
            var t2=0;
            var t3=0;
            var t4=0;
            var t5=0;
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
                me.digitado_expediente=t2;
                me.falta_digitar=t3;

                var url2=me.ruta + '/expediente/obtenerExpedienteVerificado?numero='+num;    
                axios.get(url2).then(function (response) {
                var respuesta=response.data;
                arrayT1 = respuesta.consulta;
                t4 = arrayT1[0]['verificado'];
                t5=parseInt(t1)-parseInt(t4);
                me.verificado_expediente=t4;
                me.falta_verificar=t5;
                

                })
                .catch(function (error) {
                    console.log(error);
                });
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
       seleccionarCheck(){
           if(this.checked){
               this.checked1=false;
               
               this.generarArray();
               
           }else{
               this.checked1=true;
               this.generarArray();
           }
       },
       generarArray(){
           if(this.arrayListado.length>0){
               var total=this.arrayListado.length;
               if(this.checked1){
                    for(var i = 0; i < total; i++){
                        this.nuevoArray.push({
                        idexpediente: this.arrayListado[i].id,
                        idingreso: this.arrayListado[i].idingreso
                        
                    });
                    }
                    
                }else{
                  this.nuevoArray=[];
                  this.nuevoArray.length=0;
                 
                }
            } 
               
           
       },
       asignarUbicacion(){
           let me= this;
           if(this.arrayListado.length>0){
               if(this.nuevoArray.length>0){
                   if(parseInt(this.total_expediente)==parseInt(this.digitado_expediente)){
                       var arrayT=[];
                       var t1=0;
                       var num=this.idingreso;
                       var url=me.ruta + '/expediente/obtenerTotalPaqueteUbicado?id='+num;    
                        axios.get(url).then(function (response) {
                            var respuesta=response.data;
                            arrayT = respuesta.consulta;
                            t1 = arrayT[0]['total'];
                        
                            if(parseInt(t1)==0){
                                me.abrirModal('modal','registrar');
                            }else{
                                Swal.fire('Expedientes ya fueron ubicados')
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                       
                   }else{
                       Swal.fire({
                        title: 'Error!',
                        text: 'Digite todo los expedientes',
                        icon: 'error',
                        confirmButtonText: 'OK'
                        }) 
                   }
                    
                }else{
                    Swal.fire({
                    title: 'Error!',
                    text: 'Seleccione los expedientes',
                    icon: 'error',
                    confirmButtonText: 'OK'
                    }) 
                }
            }else{
               Swal.fire({
                title: 'Paquete no contiene Exp. por asignar',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp'
                }
                })  
            }
           
       },
        abrirModal(modelo,accion){
            switch(modelo){
                case "modal":
                {
                    switch(accion){
                        case 'registrar':
                            {
                                this.modal=1;
                                this.obtenerLocal();
                                this.tituloModal='Ubicación',
                                this.idlocal=1;
                                this.paquete=0;
                                this.anaquel=0;
                                this.tipoAccion=1;
                                break;
                            }
                        
                    }
                }
            }
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.paquete=0;
            this.anaquel=0;
            
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

        asignarFocus(){
            this.$nextTick(() => {
                const editButtonRef = this.$refs.cantidad;
                editButtonRef.focus();
            });
        },

        validarRegistro(){
            this.errorUbicacion=0;
            this.errorMostrarMsjUbicacion=[];
            if(this.idingreso==0) this.errorMostrarMsjUbicacion.push("Número de ingreso incorrecto");
            if(this.idlocal==0) this.errorMostrarMsjUbicacion.push("Seleccione un local");
            if(!this.anaquel || this.anaquel==0) this.errorMostrarMsjUbicacion.push("Ingrese anaquel");
            if(!this.paquete || this.paquete==0) this.errorMostrarMsjUbicacion.push("Ingrese paquete");
            if(this.errorMostrarMsjUbicacion.length) this.errorUbicacion=1;

            return this.errorUbicacion;
        },

        // METODOS PARA REGISTRAR
        registrarUbicacion(){
            let me=this;
            var num=0;
            if(this.validarRegistro()){
                return;
            }
            axios.post(me.ruta + '/upaquete/registrar',{
                'idingreso': this.idingreso,
                'idlocal': this.idlocal,
                'anaquel': this.anaquel,
                'paquete': this.paquete,
                'idusuario': this.idusuario
  
            }).then(function(response){
                me.actualizarExpediente();
                num=me.numero_ingreso;
                me.listado=1;
                //INGRESAR METODO PARA ACTUALIZAR CAMPOS DE LA TABLA EXPEDIENTES
                me.botonActivo=false;
                
                me.cerrarModal();
                me.listarConsulta(1,num);
                me.totales(num);
                me.limpiarModal();

            }).catch(function(error){
                console.log(error);
            });
        },
        //METODOS PARA ACTUALIZAR FORMULARIO
        actualizarExpediente(){
            let me= this;
            var num=0;
            axios.put(me.ruta + '/expediente/actualizarRegistro',{
                'idlocal': this.idlocal,
                'anaquel': this.anaquel,
                'paquete': this.paquete,
                'data': this.nuevoArray

            }).then(function(response){
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Ubicación asignado',
                showConfirmButton: false,
                timer: 1500
                })
            }).catch(function(error){
                console.log(error);
            });
        },
        //METODOS PARA VERIFICAR Expedientes
        verificarPaquete(){
            let me=this;
            var num=0;
            if(this.idingreso>0){
                if(this.arrayListado.length>0){
                    if(this.nuevoArray.length>0){

                        var arrayT2=[];
                        var c1=0;
                        var arrayT3=[];
                        var c2=0;
                        var num=this.idingreso;
                        var url2=me.ruta + '/expediente/obtenerTotalPaqueteUbicado?id='+num;    
                            axios.get(url2).then(function (response) {
                                var respuesta=response.data;
                                arrayT2 = respuesta.consulta;
                                c1 = arrayT2[0]['total'];
                                if(parseInt(c1)>0){
                                    var url3=me.ruta + '/expediente/obtenerTotalPaqueteVerificado?id='+num;
                                    axios.get(url3).then(function (response) {  
                                        var respuesta=response.data;
                                        arrayT3 = respuesta.consulta;
                                        c2 = arrayT3[0]['total'];
                                        if(parseInt(c2)==0){
                                            var arrayT=[];
                                            var arrayT1=[];
                                            var tot=0;
                                            var tot1=0;
                                            var url=me.ruta + '/pverificado/obtenerTotal?numero='+me.idingreso;
                                            axios.get(url).then(function (response) {
                                                var respuesta=response.data;
                                                arrayT = respuesta.consulta;
                                                tot = arrayT[0]['total'];
                                                if(parseInt(tot)>0){
                                                    var url1=me.ruta + '/pverificado/obtenerSumaVerificado?numero='+me.idingreso;
                                                    axios.get(url1).then(function (response) {
                                                        var respuesta=response.data;
                                                        arrayT1 = respuesta.consulta;
                                                        tot1 = arrayT1[0]['acumulado'];
                                                        var canti=parseInt(me.total_expediente)-parseInt(tot1);
                                                        axios.post(me.ruta + '/pverificado/registrar',{
                                                        'idingreso': me.idingreso,
                                                        'cantidad': canti,
                                                        'idusuario': me.idusuario,

                                    
                                                        }).then(function(response){
                                                        me.actualizarExpediente1();
                                                        me.actualizarIngreso();
                                                        num=me.numero_ingreso;
                                                       
                                                        //INGRESAR METODO PARA ACTUALIZAR CAMPOS DE LA TABLA EXPEDIENTES
                                                        me.botonActivo=true;

                                                        me.listarConsulta(1,num);
                                                        me.totales(num); //modificar
                                                        me.listado=1;
                                                       
                                                         

                                                        }).catch(function(error){
                                                            console.log(error);
                                                        });
                                                    })
                                                    .catch(function (error) {
                                                        console.log(error);
                                                    });
                                                }else{
                                                    //pegar aqui codigo
                                                    var tot12=me.nuevoArray.length;
                                                    var canti=parseInt(tot12);
                                                    axios.post(me.ruta + '/pverificado/registrar',{
                                                    'idingreso': me.idingreso,
                                                    'cantidad': canti,
                                                    'idusuario': me.idusuario,

                                
                                                    }).then(function(response){
                                                        
                                                    me.actualizarExpediente1();
                                                    me.actualizarIngreso();
                                                    num=me.numero_ingreso;
                                                    
                                                    //INGRESAR METODO PARA ACTUALIZAR CAMPOS DE LA TABLA EXPEDIENTES
                                                    me.botonActivo=true;

                                                    me.listarConsulta(1,num); 
                                                    me.totales(num); //modificar
                                                    me.listado=1;
                                                    

                                                    }).catch(function(error){
                                                        console.log(error);
                                                    });
                                                    
                                                }
                                            })
                                            .catch(function (error) {
                                                console.log(error);
                                            });
                                        }else{
                                           var url1=me.ruta + '/pverificado/obtenerSumaVerificado?numero='+me.idingreso;
                                                    axios.get(url1).then(function (response) {
                                                        var respuesta=response.data;
                                                        arrayT1 = respuesta.consulta;
                                                        tot1 = arrayT1[0]['acumulado'];
                                                        var canti=0;
                                                        if(parseInt(me.total_expediente)==parseInt(tot1)){
                                                            canti=parseInt(me.total_expediente);
                                                        }
                                                        else{
                                                            canti=parseInt(me.total_expediente)-parseInt(tot1);
                                                        }
                                                        var canti=parseInt(me.total_expediente)-parseInt(tot1);
                                                        axios.put(me.ruta + '/pverificado/actualizar',{
                                                        'idingreso': me.idingreso,
                                                        'cantidad': canti,
                                                        

                                    
                                                        }).then(function(response){
                                                        me.actualizarExpediente1();
                                                        me.actualizarIngreso();
                                                        num=me.numero_ingreso;
                                                       
                                                        //INGRESAR METODO PARA ACTUALIZAR CAMPOS DE LA TABLA EXPEDIENTES
                                                        me.botonActivo=true;

                                                        me.listarConsulta(1,num);
                                                        me.totales(num); //modificar
                                                        me.listado=1;
                                                       
                                                         

                                                        }).catch(function(error){
                                                            console.log(error);
                                                        });
                                                    })
                                                    .catch(function (error) {
                                                        console.log(error);
                                                    });
                                            }
                                        })
                                        .catch(function (error) {
                                            console.log(error);
                                        });    
                                }else{
                                    Swal.fire('Expedientes aun no fueron ubicados')
                                }
                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                        

                    }else{
                        Swal.fire({
                        title: 'Error!',
                        text: 'Seleccione los expedientes',
                        icon: 'error',
                        confirmButtonText: 'OK'
                        }) 
                    }
                        

                    
                }else{
                    Swal.fire({
                    title: 'Paquete no contiene Exp. por verificar',
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                    }) 
                }
                    
            }else{
              Swal.fire({
                title: 'Error!',
                text: 'Vuelva intentar otra vez',
                icon: 'error',
                confirmButtonText: 'OK'
                })  
            }
            
        },
        actualizarExpediente1(){
            let me= this;
            var num=0;
            axios.put(me.ruta + '/expediente/actualizarRegistro1',{
                'data': this.nuevoArray

            }).then(function(response){
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Verificación con éxito',
                showConfirmButton: false,
                timer: 1500
                })
            }).catch(function(error){
                console.log(error);
            });
        },
        actualizarIngreso(){
            let me= this;
           
            var ca=me.nuevoArray.length;
            var arrayT=[];
            var acu=0;
            var url=me.ruta + '/ingreso/obtenerTotalVerificado?numero='+me.idingreso;
            axios.get(url).then(function (response) {
                var respuesta=response.data;
                arrayT = respuesta.consulta;
                acu = arrayT[0]['acumulado'];
                var act=parseInt(acu)+parseInt(ca);
                axios.put(me.ruta + '/ingreso/actualizarRegistro',{
                'digitado': act,
                'id': me.idingreso

                }).then(function(response){
                    
                }).catch(function(error){
                    console.log(error);
                });
            })
            .catch(function (error) {
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
       limpiarModal(){
            let me = this;
            me.titulo='';
            me.errorUbicacion=0;
            me.errorMostrarMsjUbicacion=[];
            me.idlocal=1;
            me.anaquel=0;
            me.paquete=0;

        },
        limpiarCampo(){
            let me = this;
            me.titulo='';
            me.errorRegistro=0;
            me.errorMostrarMsjRegistro=[];
        },

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