<template>
   <section class="content">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
            
                <li class="breadcrumb-item"><a href="main">Escritorio</a></li>
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Tipo Personal
                        <button type="button" @click="abrirModal('tipopersonal','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarTipopersonal(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarTipopersonal(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tipopersonal in arrayTipopersonal" :key="tipopersonal.id">
                                    <td>
                                        <button type="button" @click="abrirModal('tipopersonal','actualizar',tipopersonal)" class="btn btn-warning btn-sm">
                                          <i class="fa fa-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="tipopersonal.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarTipopersonal(tipopersonal.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarTipopersonal(tipopersonal.id)">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="tipopersonal.nombre"></td>
                                    
                                    <td>
                                        <div v-if="tipopersonal.condicion">
                                            <span class="badge badge-success">Activo</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                        
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
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">??</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input  type="text"  v-model="nombre" class="form-control" placeholder="Nombre de Tipo Personal">
                                        
                                    </div>
                                </div>
                               
                                <div v-show="errorTipopersonal" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjTipopersonal" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarTipopersonal()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarTipopersonal()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
            <!-- Inicio del modal Eliminar -->
           
            <!-- Fin del modal Eliminar -->
            
        </section>
</template>

<script>
    export default {
        props: ['ruta'],
        data(){
            return {
                tipopersonal_id: 0,
                nombre : '',
               
                arrayTipopersonal : [],
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorTipopersonal: 0,
                errorMostrarMsjTipopersonal: [],
                pagination :{
                        'total' :0,
                        'current_page' :0,
                        'per_page' :0,
                        'last_page' :0,
                        'from' :0,
                        'to' :0,
                },
                offset: 3,
                criterio: 'nombre',
                buscar: ''
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
        listarTipopersonal (page,buscar,criterio){
                let me=this;
                var url=me.ruta + '/tipopersonal?page=' + page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayTipopersonal = respuesta.tipopersonales.data;
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
            me.listarTipopersonal(page,buscar,criterio);

        },
        registrarTipopersonal(){
            if(this.validarTipopersonal()){
                return;
            }

            let me = this;
            axios.post(me.ruta + '/tipopersonal/registrar',{
                'nombre': this.nombre
                
            }).then(function(response){
                me.cerrarModal();
                me.listarTipopersonal(1,'','nombre');

            }).catch(function(error){
                console.log(error);
            });

        },
        actualizarTipopersonal(){
            if(this.validarTipopersonal()){
                return;
            }

            let me = this;
            axios.put(me.ruta + '/tipopersonal/actualizar',{
                'nombre': this.nombre,
                
                'id': this.tipopersonal_id
                
            }).then(function(response){
                me.cerrarModal();
                me.listarTipopersonal(1,'','nombre');
               
            }).catch(function(error){
                console.log(error);
            });
        },
        desactivarTipopersonal(id){
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
                        axios.put(me.ruta + '/tipopersonal/desactivar',{
                            'id': id
                           
                        }).then(function(response){
        
                            me.listarTipopersonal(1,'','nombre');
                             swalWithBootstrapButtons.fire(
                            'Desactivado!',
                            'El registro ha sido desactivado con ??xito',
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
        activarTipopersonal(id){
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
                        axios.put(me.ruta + '/tipopersonal/activar',{
                            'id': id
                           
                        }).then(function(response){
        
                            me.listarTipopersonal(1,'','nombre');
                             swalWithBootstrapButtons.fire(
                            'Activado!',
                            'El registro ha sido activado con ??xito',
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
        validarTipopersonal(){
            this.errorTipopersonal=0;
            this.errorMostrarMsjTipopersonal=[];

            if(!this.nombre) this.errorMostrarMsjTipopersonal.push("El nombre  no puede estar vacio");

            if(this.errorMostrarMsjTipopersonal.length) this.errorTipopersonal=1;

            return this.errorTipopersonal;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.nombre='';
            
        },
        abrirModal(modelo,accion,data=[]){
            switch(modelo){
                case "tipopersonal":
                {
                    switch(accion){
                        case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Tipo Personal',
                                this.nombre='';
                               
                                this.tipoAccion=1;
                                break;
                            }
                        case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Tipo Personal';
                                this.tipoAccion=2;
                                this.tipopersonal_id=data['id'];
                                this.nombre=data['nombre'];
                               
                                break;
                            }
                    }
                }
            }
        }
        },
        mounted() {
            this.listarTipopersonal(1,this.buscar,this.criterio);
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