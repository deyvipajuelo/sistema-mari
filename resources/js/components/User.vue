
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
                        <i class="fa fa-align-justify"></i> Usuarios
                        <button type="button" @click="abrirModal('usuario','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="apellido">Apellido</option>
                                      <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarUsuario(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarUsuario(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Apellido</th>
                                    <th>Nombre</th>
                                    <th>Usuario</th>
                                    <th>Rol</th>
                                    <th>Condicion</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="usuario in arrayUsuario" :key="usuario.id">
                                    <td>
                                        <button type="button" @click="abrirModal('usuario','actualizar',usuario)" class="btn btn-warning btn-sm">
                                          <i class="fa fa-pencil"></i>
                                        </button> 
                                        &nbsp;
                                        <template v-if="usuario.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUsuario(usuario.id)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarUsuario(usuario.id)">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <td v-text="usuario.apellido"></td>
                                    <td v-text="usuario.nombre"></td>
                                    <td v-text="usuario.usuario"></td>
                                    <td v-text="usuario.rol"></td>
                                    <td>
                                        <div v-if="usuario.condicion">
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
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Persona</label>
                                    <div class="col-md-9">
                                        <template v-if="tipoAccion==1">
                                           <v-select
                                            v-model="item" 
                                            :value.sync="arrayPersona.id" 
                                            :options="arrayPersona" 
                                            label="persona">
                                       </v-select> 
                                       <span class="col-md-3 form-control" v-text="item.idpersona" style="display: none"> {{item.idpersona}}</span>
                                        </template>
                                       <template v-if="tipoAccion==2">
                                           <span  v-text="nombre_persona"> </span> 
                                       </template>
                                       
                                    </div>
                                </div>
                               
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Rol(*)</label>
                                    <div class="col-md-9">
                                       <select class="form-control" v-model="idrol">
                                           <option value="0">Seleccione un Rol</option>
                                           <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                       </select>
                                    </div>
                                </div>
                                <div class="form-group row" style="display: none">
                                    <label class="col-md-3 form-control-label" for="text-input">Oficial de Seguridad(*)</label>
                                    <div class="col-md-9">
                                       <select class="form-control" v-model="oficial">
                                           <option value="NO">NO</option>
                                           <option value="SI">SI</option>
                                       </select>
                                    </div>
                                </div>
                                 <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Usuario(*)</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Ingrese Usuario">
                                    </div>
                                </div>
                                <template v-if="tipoAccion==2">
                                   <label class="col-md-7 form-control-label" for="text-input">¿Desea Cambiar la contraseña?</label>
                                    <input type="checkbox" id="checkbox" v-model="checked" />
                                    <label for="checkbox">{{ checked }}</label> 
                                    <template v-if="checked">
                                    <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Password(*)</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Ingrese Contraseña">
                                    </div>
                                    </div>
                                </template>
                                </template>
                                
                                <template v-if="tipoAccion==1">
                                    <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Password(*)</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Ingrese Contraseña">
                                    </div>
                                </div>
                                </template>
                                
                                
                                
                                <div v-show="errorUsuario" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjUsuario" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUsuario()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarUsuario()">Actualizar</button>
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
    import vSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css'; 
    export default {
        
        components: {
           vSelect
        },
        props: ['ruta'],
        data(){
            return {
                checked: false,
                item:{
                    idpersona: 0,
                    persona: ''
                },
                usuario_id: 0,
                idpersona1: 0,
                nombre_persona : '',
                oficial: '',
                
                usuario: '',
                password: '',
                idrol: 0,
                arrayUsuario : [],
                arrayRol : [],
                arrayPersona: [],
                modal : 0,
                tituloModal : '',
                tipoAccion: 0,
                errorUsuario: 0,
                errorMostrarMsjUsuario: [],
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
                buscar: '',
                aceptar: 0
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
           
        
        listarUsuario (page,buscar,criterio){
                let me=this;
                var url=me.ruta + '/user?page=' + page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayUsuario = respuesta.usuarios.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectRol(){
          let me=this;
                var url=me.ruta + '/rol/selectRol';
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayRol = respuesta.roles;
                   
                })
                .catch(function (error) {
                    console.log(error);
                });  
        },
        selectPersona(){
          let me=this;
                var url=me.ruta + '/persona/selectPersona';
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayPersona = respuesta.personas;
                   
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
            me.listarUsuario(page,buscar,criterio);

        },
        registrarUsuario(){
            if(this.validarUsuario()){
                return;
            }

            let me = this;
            axios.post(me.ruta + '/user/registrar',{
                'idpersona': this.item.idpersona,
                
                'usuario':this.usuario,
                'password':this.password,
                'idrol': this.idrol,
                'oficial': this.oficial
            }).then(function(response){
                me.cerrarModal();
                me.listarUsuario(1,'','nombre');

            }).catch(function(error){
                console.log(error);
            });
           
        },
        actualizarUsuario(){
            if(this.validarUsuario()){
                return;
            }

            let me = this;
            axios.put(me.ruta + '/user/actualizar',{
                'usuario':this.usuario,
                'password':this.password,
                'idrol': this.idrol,
                'oficial':this.oficial,
                'id': this.usuario_id,
                'checked': this.checked
                
            }).then(function(response){
                me.cerrarModal();
                me.listarUsuario(1,'','nombre');
               
            }).catch(function(error){
                console.log(error);
            });
        },
        desactivarUsuario(id){
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
                        axios.put(me.ruta + '/user/desactivar',{
                            'id': id
                           
                        }).then(function(response){
        
                            me.listarUsuario(1,'','nombre');
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
        activarUsuario(id){
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
                        axios.put(me.ruta + '/user/activar',{
                            'id': id
                           
                        }).then(function(response){
        
                            me.listarUsuario(1,'','nombre');
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
        validarUsuario(){
            this.errorUsuario=0;
            this.errorMostrarMsjUsuario=[];
            if(this.tipoAccion==1){
                if(this.item.idpersona==0) this.errorMostrarMsjUsuario.push("Seleccione persona");
                if(!this.usuario) this.errorMostrarMsjUsuario.push("Ingrese nombre de usuario");
                if(!this.password) this.errorMostrarMsjUsuario.push("Ingrese password");
                if(this.idrol==0) this.errorMostrarMsjUsuario.push("Seleccione un Rol");
            }else{
                if(this.checked){
                    if(!this.usuario) this.errorMostrarMsjUsuario.push("Ingrese nombre de usuario");
                    if(this.idrol==0) this.errorMostrarMsjUsuario.push("Seleccione un Rol");
                    if(!this.password) this.errorMostrarMsjUsuario.push("Ingrese password");   
                }else{
                    if(!this.usuario) this.errorMostrarMsjUsuario.push("Ingrese nombre de usuario");
                    if(this.idrol==0) this.errorMostrarMsjUsuario.push("Seleccione un Rol"); 
                }
                
            }
            
            if(this.errorMostrarMsjUsuario.length) this.errorUsuario=1;

            return this.errorUsuario;
        },
        cerrarModal(){
            this.modal=0;
            this.tituloModal='';
            this.idpersona=0;
            this.idpersona=1;
            this.item.idpersona=0;
            this.item.persona='';
            this.usuario='';
            this.password='';
            this.idrol=0;
            this.nombre_persona='';
            this.errorUsuario=0;
            this.checked=false;
            this.oficial='NO';
        },
        abrirModal(modelo,accion,data=[]){
            this.selectRol();
            this.selectPersona();
            
            switch(modelo){
                case "usuario":
                {
                    switch(accion){
                        case 'registrar':
                            {
                                this.modal=1;
                                this.tituloModal='Registrar Usuario',
                                this.idpersona1=0;
                                this.item.idpersona=0;
                                this.item.persona='';
                                this.usuario='';
                                this.password='';
                                this.idrol=0;
                                this.oficial='NO';
                                this.tipoAccion=1;
                                this.checked=false;
                                break;
                            }
                        case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Usuario';
                                this.tipoAccion=2;
                                this.usuario_id=data['id'];
                                this.nombre_persona=data['persona'];
                               
                                this.usuario=data['usuario'];
                                this.password=data['password'];
                                this.idrol=data['idrol'];
                                this.oficial=data['oficial'];
                                break;
                            }
                    }
                }
            }
        }
        },
        mounted() {
            this.listarUsuario(1,this.buscar,this.criterio);
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

    .demo {
  font-family: sans-serif;
  border: 1px solid #eee;
  border-radius: 2px;
  padding: 20px 30px;
  margin-top: 1em;
  margin-bottom: 40px;
  user-select: none;
  overflow-x: auto;
}
</style>