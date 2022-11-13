
<template>
    <section class="content">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
               
                <li class="breadcrumb-item"><a href="main">Escritorio</a></li>
                
            </ol>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Cambiar Constraseña</h3>
                        </div>
                        <form method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Contraseña Nueva</label>
                                    <input type="password" class="form-control" v-model="password" placeholder="Nueva Contraseña">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" v-model="confirpassword" placeholder="Confirmar Contraseña">
                                </div>
                                <div v-show="errorUsuario" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjUsuario" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="button" class="btn btn-primary" @click="actualizarUsuario()">Guardar</button>
                            </div>
                        </form>
                    </div>
           
                </div>
            </div><!-- /.container-fluid -->
        </div>
        </section>
</template>

<script>
    import vSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css'; 
    export default {
        props: ['ruta'],
        components: {
           vSelect
        },

        data(){
            return {
                
                usuario_id: 0,
               
                password: '',
                confirpassword: '',
                errorUsuario: 0,
                errorMostrarMsjUsuario: [],
                
            }
        },
        computed:{
            
        },
    
        methods : {
        selectPersona(){
            let me=this;
            var url=me.ruta + '/user/obtenerPersona';
            var arrayUsuario=[];
            axios.get(url).then(function (response) {
                var respuesta=response.data;
               arrayUsuario = respuesta.personas;
               me.usuario_id=arrayUsuario[0]['id'];
                
            })
            .catch(function (error) {
                console.log(error);
            });  
        },
        
        actualizarUsuario(){
            if(this.validarUsuario()){
                return;
            }

            let me = this;
            axios.put(me.ruta + '/user/actualizarPassword',{
                'password':me.password,
                'id': me.usuario_id
                
            }).then(function(response){
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Contraseña Actualizado',
                showConfirmButton: false,
                timer: 1500
                })
                me.password='';
                me.confirpassword='';
               
            }).catch(function(error){
                console.log(error);
            });
        },
        
        validarUsuario(){
            this.errorUsuario=0;
            this.errorMostrarMsjUsuario=[];
            
                if(!this.password){
                    this.errorMostrarMsjUsuario.push("Ingrese Contraseña");
                }else{
                    if(!this.confirpassword){
                        this.errorMostrarMsjUsuario.push("Ingrese contraseña de confirmación");
                    }else{
                       if(this.password!=this.confirpassword){
                           this.errorMostrarMsjUsuario.push("Las constraseñas no coinciden");
                       }  
                    }
                }

                if(this.errorMostrarMsjUsuario.length) this.errorUsuario=1;

                return this.errorUsuario;
        },
        
        
        },
        mounted() {
            this.selectPersona();
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