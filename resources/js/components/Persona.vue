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
                        <i class="fa fa-align-justify"></i> Personas
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <!-- LISTADO -->
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="apellido">Apellido</option>
                                      <option value="dni">DNI</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive p-1">
                            <table class="table table-bordered text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Opciones</th>
                                        <th>DNI</th>
                                        <th>Persona</th>
                                        <th>Perfil</th>
                                        <th>Cargo</th>
                                        <th>Instancia</th>
                                        <th>Area</th>
                                        <th>Correo</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="persona in arrayPersona" :key="persona.id">
                                        <td>
                                            <button type="button" @click="actualizarDetalle(persona)" class="btn btn-warning btn-sm">
                                            <i class="fa fa-pencil"></i>
                                            </button> &nbsp;
                                            <template v-if="persona.condicion">
                                                <button type="button" class="btn btn-danger btn-sm" @click="desactivarPersona(persona.id)">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button type="button" class="btn btn-info btn-sm" @click="activarPersona(persona.id)">
                                                    <i class="fa fa-check"></i>
                                                </button>
                                            </template>
                                        </td>
                                        <td v-text="persona.dni"></td>
                                        <td >{{persona.apellido+' '+persona.nombre}}</td>
                                        <td v-text="persona.perfil"></td>
                                        <td v-text="persona.personal"></td>
                                        <td v-text="persona.instancia"></td>
                                        <td v-text="persona.area"></td>
                                        <td v-text="persona.correo"></td>
                                        <td>
                                            <div v-if="persona.condicion">
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
                     <!--REGISTRAR -->
                     <template v-else-if="listado==0">
                    <div class="card-body">
                        <form @submit.prevent="registrarPersona" enctype="multipart/form-data">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Perfil</label>
                                    <select class="form-control" v-model="idperfil">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="perfil in arrayPerfil" :key="perfil.id" :value="perfil.id" v-text="perfil.nombre"></option>
                                       </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="text-input">DNI</label>
                                <input  type="text"  v-model="dni" class="form-control" @keypress="soloNumero" maxlength="8" placeholder="Ingrese DNI">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Apellido</label>
                                    <input  type="text"  v-model="apellido" class="form-control" placeholder="Ingrese Apellido">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Nombre</label>
                                    <input  type="text"  v-model="nombre" class="form-control" placeholder="Ingrese Nombre">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Correo electrónico</label>
                                    <input  type="email"  v-model="correo" class="form-control" placeholder="usuario@pj.gob.pe">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Sede</label>
                                    <select class="form-control" v-model="idsede">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="sede in arraySede" :key="sede.id" :value="sede.id" v-text="sede.nombre"></option>
                                       </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <label for="text-input">Tipo Personal</label>
                                    <select class="form-control" v-model="idtipopersonal" @change='selectPersonal()'>
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="tipopersonal in arrayTipopersonal" :key="tipopersonal.id" :value="tipopersonal.id" v-text="tipopersonal.nombre"></option>
                                       </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <label for="text-input">Cargo</label>
                                    <select class="form-control" v-model="idpersonal">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="personal in arrayPersonal" :key="personal.id" :value="personal.id" v-text="personal.nombre"></option>
                                       </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <label for="text-input">Area</label>
                                   <select class="form-control" v-model="idarea" @change='selectInstancia()'>
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="area in arrayArea" :key="area.id" :value="area.id" v-text="area.nombre"></option>
                                       </select>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                   <label for="text-input">Instancia</label>
                                   <select class="form-control" v-model="idinstancia">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="instancia in arrayInstancia" :key="instancia.id" :value="instancia.id" v-text="instancia.nombre"></option>
                                       </select>
                                </div>
                                </div>
                                 <div class="col-md-6">
                                <div class="form-group">
                                   <label for="text-input">Sexo</label>
                                   <select class="form-control" v-model="sexo">
                                           <option value="M">M</option>
                                           <option value="F">F</option>
                                       </select>
                                </div>
                                </div>
                            
                            <div class="col-md-12">
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <input type="submit" value="Guardar">
                              
                            </div>
                        </div>
                         </form>
                        
                    </div>
                     </template>
                     <!-- FIN REGISTRAR -->
                     <!-- EDITAR -->
                     <template v-else-if="listado==2">
                    <div class="card-body">
                    <form method="post" @submit.prevent="actualizarPersona" enctype="multipart/form-data">
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Perfil</label>
                                    <select class="form-control" v-model="idperfil">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="perfil in arrayPerfil" :key="perfil.id" :value="perfil.id" v-text="perfil.nombre"></option>
                                       </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="text-input">DNI</label>
                                <input  type="text"  v-model="dni" class="form-control" @keypress="soloNumero" maxlength="8" placeholder="Ingrese DNI">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Apellido</label>
                                    <input  type="text"  v-model="apellido" class="form-control" placeholder="Ingrese Apellido">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Nombre</label>
                                    <input  type="text"  v-model="nombre" class="form-control" placeholder="Ingrese Nombre">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Correo electrónico</label>
                                    <input  type="email"  v-model="correo" class="form-control" placeholder="usuario@pj.gob.pe">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="text-input">Sede</label>
                                    <select class="form-control" v-model="idsede">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="sede in arraySede" :key="sede.id" :value="sede.id" v-text="sede.nombre"></option>
                                       </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <label for="text-input">Tipo Personal</label>
                                    <select class="form-control" v-model="idtipopersonal" @change='selectPersonal()'>
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="tipopersonal in arrayTipopersonal" :key="tipopersonal.id" :value="tipopersonal.id" v-text="tipopersonal.nombre"></option>
                                       </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <label for="text-input">Cargo</label>
                                    <select class="form-control" v-model="idpersonal">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="personal in arrayPersonal" :key="personal.id" :value="personal.id" v-text="personal.nombre"></option>
                                       </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <label for="text-input">Area</label>
                                   <select class="form-control" v-model="idarea" @change='selectInstancia()'>
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="area in arrayArea" :key="area.id" :value="area.id" v-text="area.nombre"></option>
                                       </select>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                   <label for="text-input">Instancia</label>
                                   <select class="form-control" v-model="idinstancia">
                                           <option value="0" disabled>Seleccione</option>
                                           <option v-for="instancia in arrayInstancia" :key="instancia.id" :value="instancia.id" v-text="instancia.nombre"></option>
                                       </select>
                                </div>
                                </div>
                                <div class="col-md-6">
                                <div class="form-group">
                                   <label for="text-input">Sexo</label>
                                   <select class="form-control" v-model="sexo">
                                           <option value="M">M</option>
                                           <option value="F">F</option>
                                       </select>
                                </div>
                                </div>
                            
                            <div class="col-md-12">
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary">Cerrar</button>
                                <input type="submit" class="btn btn-primary" value="Actualizar">

                            </div>
                        </div>
                         </form>
                        
                    </div>
                     </template>
                     <!-- FIN EDITAR -->
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
           
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
                persona_id: 0,
                idsede: 0,
                idperfil:0,
                idpersonal: 0,
                idinstancia: 0,

                idtipopersonal: 0,
                idarea: 0,
                perfil : '',
                area : '',
                personal : '',
                instancia : '',

                dni: 0,
                apellido: '',
                nombre: '',
                correo: '',
                ruta0: '',
                ruta1: '',

                listado: 1,
                condi: 0,

                firmaMiniatura: '',
                
                sexo: 'M',

                arrayPersona : [],
                arraySede: [],
                arrayPerfil: [],
                arrayPersonal: [],
                arrayInstancia: [],
                arrayArea: [],
                titulo: '',
                errorPersona: 0,
                errorMostrarMsjPersona: [],
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
                arrayTipopersonal: []
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
            },
            firma(){
                return this.firmaMiniatura;
            }

        },
        methods : {
        listarPersona (page,buscar,criterio){
                let me=this;
                var url=me.ruta + '/persona?page=' + page+'&buscar='+buscar+'&criterio='+criterio;
                axios.get(url).then(function (response) {
                    var respuesta=response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination=respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectSede(){
            let me=this;
                var url=me.ruta + '/sede/selectSede';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arraySede = respuesta.sedes;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectPerfil(){
            let me=this;
                var url=me.ruta + '/perfil/selectPerfil';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayPerfil = respuesta.perfiles;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectInstancia(){
            let me=this;
                var url=me.ruta + '/instancia/comboInstancia';
                axios.get(url,{
                    params: {
                        idarea: this.idarea
                 }
                 }).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayInstancia = respuesta.comboinstancia;
                    
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        validarEmail: function (valor) {
            var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(valor);
        },
        selectPersonal(){
            let me=this;
                var url=me.ruta + '/personal/comboPersonal';
                axios.get(url,{
                 params: {
                   idtipopersonal: this.idtipopersonal
                 }
                 }).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayPersonal = respuesta.combopersonal;
                    
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectArea(){
            let me=this;
                var url=me.ruta + '/area/selectArea';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayArea = respuesta.areas;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
        },
        selectTipopersonal(){
            let me=this;
                var url=me.ruta + '/tipopersonal/selectTipopersonal';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    me.arrayTipopersonal = respuesta.tipopersonales;
                    
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
            me.listarPersona(page,buscar,criterio);

        },
        registrarPersona(){
            if(this.validarPersona()){
                return;
            }
            let me = this;
            
            let formData=new FormData();
            formData.append('idsede',this.idsede);
            formData.append('idperfil',this.idperfil);
            formData.append('idpersonal',this.idpersonal);
            formData.append('idinstancia',this.idinstancia);
            formData.append('apellido',this.apellido);
            formData.append('nombre',this.nombre);
            formData.append('dni',this.dni);
            formData.append('correo',this.correo);
            formData.append('sexo',this.sexo);
            //formData.append('ruta',this.ruta);
           
            axios.post(me.ruta + '/persona/registrar',formData)
            .then(response=>{
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Registro con Éxito',
                    showConfirmButton: false,
                    timer: 1500
                    })
                me.listado=1;
                me.listarPersona(1,'','nombre');
                 me.limpiarCampo();

            }).catch(function(error){
                console.log(error);
            });

        },
        registrarPersona1(){
            if(this.validarPersona()){
                return;
            }

            let me = this;
            let rt=this.ruta;
            axios.post(me.ruta + '/persona/registrar',{
                'idsede': this.idsede,
                'idperfil': this.idperfil,
                'idpersonal': this.idpersonal,
                'idinstancia': this.idinstancia,
                'apellido': this.apellido,
                'nombre': this.nombre,
                'dni': this.dni,
                'correo': this.correo,
                'sexo': this.sexo
                //'ruta': this.ruta
               
                
                
            }).then(function(response){
                
                me.listado=1;
                me.listarPersona(1,'','nombre');
                 me.limpiarCampo();

            }).catch(function(error){
                console.log(error);
            });

        },
        actualizarPersona(){
            if(this.validarPersona()){
                return;
            }
            let me = this;
            
            let data=new FormData();
            data.append('id',this.persona_id);
            data.append('idsede',this.idsede);
            data.append('idperfil',this.idperfil);
            data.append('idpersonal',this.idpersonal);
            data.append('idinstancia',this.idinstancia);
            data.append('apellido',this.apellido);
            data.append('nombre',this.nombre);
            data.append('dni',this.dni);
            data.append('correo',this.correo);
            data.append('sexo',this.sexo);
            //data.append('ruta',this.ruta);
            
            axios.post(me.ruta + '/persona/actualizar',data)
            .then(response=>{
              Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Actualización con Éxito',
                    showConfirmButton: false,
                    timer: 1500
                    })
                me.listado=1;
                me.listarPersona(1,'','nombre');
                me.limpiarCampo();

            }).catch(function(error){
                console.log(error);
            });

        },
        actualizarPersona1(){
            if(this.validarPersona()){
                return;
            }

            let me = this;
            axios.put(me.ruta + '/persona/actualizar',{
                'idsede': this.idsede,
                'idperfil': this.idperfil,
                'idpersonal': this.idpersonal,
                'idinstancia': this.idinstancia,
                'apellido': this.apellido,
                'nombre': this.nombre,
                'dni': this.dni,
                'correo': this.correo,
                'sexo':this.sexo,
               // 'ruta': this.ruta,
               
                'id': this.persona_id
                
            }).then(function(response){
                console.log(response.data);
                me.listado=1;
                me.limpiarCampo();
                me.listarPersona(1,'','nombre');
               
            }).catch(function(error){
                console.log(error);
            });
        },
        desactivarPersona(id){
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
                        axios.put(me.ruta + '/persona/desactivar',{
                            'id': id
                           
                        }).then(function(response){
        
                            me.listarPersona(1,'','nombre');
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
        activarPersona(id){
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
                        axios.put(me.ruta + '/persona/activar',{
                            'id': id
                           
                        }).then(function(response){
        
                            me.listarPersona(1,'','nombre');
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
        validarPersona(){
            this.errorPersona=0;
            this.errorMostrarMsjPersona=[];

            if(this.idsede==0) this.errorMostrarMsjPersona.push("Seleccione Sede");
            if(this.idperfil==0) this.errorMostrarMsjPersona.push("Seleccione Perfil");
            if(this.idpersonal==0) this.errorMostrarMsjPersona.push("Seleccione Cargo");
            if(this.idinstancia==0) this.errorMostrarMsjPersona.push("Seleccione Instancia");
            if(!this.apellido) this.errorMostrarMsjPersona.push("Ingrese Apellidos");
            if(!this.nombre) this.errorMostrarMsjPersona.push("Ingrese Nombres");
            if(!this.dni) this.errorMostrarMsjPersona.push("Ingrese DNI");
            if(!this.correo || !this.validarEmail(this.correo)) this.errorMostrarMsjPersona.push("Ingrese un correo electrónico válido");
            if(!this.sexo) this.errorMostrarMsjPersona.push("Seleccione Sexo");
            /*
            if(this.condi==1){
                if(!this.ruta) this.errorMostrarMsjPersona.push("Seleccione Firma"); 
            }
           
            */
            if(this.errorMostrarMsjPersona.length) this.errorPersona=1;

            return this.errorPersona;
        },
        cargarCombos(){
            let me = this;
            me.selectArea();
            me.selectPerfil();
            me.selectSede();
            me.selectTipopersonal();

            //this.selectInstancia();
            //this.selectPersonal();
        },
        mostrarDetalle(){
            this.listado=0;
            this.limpiarCampo();
            this.cargarCombos();
        },
        ocultarDetalle(){
            this.listado=1;
            this.limpiarCampo();
        },
        actualizarDetalle(data=[]){
            this.listado=2;
            this.condi=0;
            this.persona_id=data['id'];
            //let rt=data['ruta'];
             //this.idarea=data['idarea']; 
            this.idsede=data['idsede'];
            this.idpersonal=data['idpersonal'];
            this.idinstancia=data['idinstancia'];
            this.idperfil=data['idperfil'];
            this.apellido=data['apellido'];         
            this.nombre=data['nombre'];
            this.dni=data['dni'];
            this.correo=data['correo'];
            this.sexo=data['sexo'];
            //this.ruta1=data['ruta'];

            this.idarea=data['idarea'];
            this.idtipopersonal=data['idtipopersonales'];
            this.cargarCombos();
            this.selectInstancia();
            this.selectPersonal();
           // console.log(data['ruta']);
        },
        limpiarCampo(){
            this.titulo='';
            this.idsede=0;
            this.idperfil=0;
            this.idpersonal=0;
            this.idinstancia=0;
            this.idtipopersonal=0;
            this.idarea=0;
            this.perfil= '',
            this.area= '',
            this.personal= '',
            this.instancia= '',
            this.dni='';
            this.apellido='';
            this.nombre='';
            this.correo='';
            this.sexo='M';
            this.ruta0='';
            this.firmaMiniatura='';
            this.condi=0;
            this.errorPersona=0;
        },
        obtenerFirma(e){
            let file=e.target.files[0];
            this.ruta0=file;
            //this.ruta1=file;
            this.condi=1;
           // console.log(file);
            this.cargarFirma(file);
        },
        cargarFirma(file){
            let reader = new FileReader();
            reader.onload=(e)=>{
                this.firmaMiniatura=e.target.result;
            }
            reader.readAsDataURL(file);
        },
        //OTROS METODOS
        soloNumero($event) {
        //console.log($event.keyCode); //keyCodes value
        let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
            if ((keyCode < 48 || keyCode > 57)) { // 46 is dot
                $event.preventDefault(); 
            }
        }
        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
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