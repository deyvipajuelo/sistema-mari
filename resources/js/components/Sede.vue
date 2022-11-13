<template>
     <section class="content">
          <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="main">Escritorio</a></li>
            </ol>
      <!-- Default box -->
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i>Sede
                        <button type="button"  @click="abrirModal('sede','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
            </div>
            <div class="card-body">
               <div class="form-group row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <select class="form-control col-md-3" v-model="criterio">
                                <option value="nombre">Sede</option>
                                      
                            </select>
                            <input type="text" v-model="buscar" @keyup.enter="listarSede(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                            <button type="submit" @click="listarSede(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
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
                    <tr v-for="sede in arraySede" :key="sede.id">
                      <td>
                            <button type="button" @click="abrirModal('sede','actualizar',sede)" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i></button> &nbsp;
                            <template v-if="sede.condicion">
                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarSede(sede.id)">
                                <i class="fa fa-trash"></i></button>
                            </template>
                            <template v-else>
                                <button type="button" class="btn btn-info btn-sm" @click="activarSede(sede.id)">
                                <i class="icon-check"></i></button>
                            </template>
                        </td>
                        <td v-text="sede.nombre"></td>
                        <td>
                            <div v-if="sede.condicion">
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
                <!-- /.card-body -->
            <div class="card-footer">
                <label for="">xd</label>
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
                <!-- /.card-footer-->
        </div>

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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input  type="text"  v-model="nombre" class="form-control" placeholder="Nombre de sede">
                                        
                                    </div>
                                </div>
                               
                                <div v-show="errorSede" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjSede" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                </form>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarSede()">Guardar</button>
                <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarSede()">Actualizar</button>
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
                sede_id: 0,
                nombre : '',
               
                arraySede : [],
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorSede: 0,
                errorMostrarMsjSede: [],
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
        listarSede (page,buscar,criterio){
            
                let me=this;
                var url=me.ruta + '/sede?page=' + page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arraySede = respuesta.sedes.data;
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
            me.listarSede(page,buscar,criterio);

        },
        registrarSede(){
            if(this.validarSede()){
                return;
            }

            let me = this;
            axios.post(me.ruta + '/sede/registrar',{
                'nombre': this.nombre
                
            }).then(function(response){
                me.cerrarModal();
                me.listarSede(1,'','nombre');

            }).catch(function(error){
                console.log(error);
            });

        },
        actualizarSede(){
            if(this.validarSede()){
                return;
            }

            let me = this;
            axios.put(me.ruta + '/sede/actualizar',{
                'nombre': this.nombre,
                
                'id': this.sede_id
                
            }).then(function(response){
                me.cerrarModal();
                me.listarSede(1,'','nombre');
               
            }).catch(function(error){
                console.log(error);
            });
        },
        desactivarSede(id){
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
                        axios.put(me.ruta + '/sede/desactivar',{
                            'id': id
                           
                        }).then(function(response){
        
                            me.listarSede(1,'','nombre');
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
        activarSede(id){
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
                        axios.put(me.ruta + '/sede/activar',{
                            'id': id
                           
                        }).then(function(response){
        
                            me.listarSede(1,'','nombre');
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
        validarSede(){
            this.errorSede=0;
            this.errorMostrarMsjSede=[];

            if(!this.nombre) this.errorMostrarMsjSede.push("El nombre de la sede no puede estar vacio");

            if(this.errorMostrarMsjSede.length) this.errorSede=1;

            return this.errorSede;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.nombre='';
            
        },
        abrirModal(modelo,accion,data=[]){
            switch(modelo){
                case "sede":
                {
                    switch(accion){
                        case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Sede',
                                this.nombre='';
                               
                                this.tipoAccion=1;
                                break;
                            }
                        case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Sede';
                                this.tipoAccion=2;
                                this.sede_id=data['id'];
                                this.nombre=data['nombre'];
                               
                                break;
                            }
                    }
                }
            }
        }
        },
        mounted() {
            this.listarSede(1,this.buscar,this.criterio);
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