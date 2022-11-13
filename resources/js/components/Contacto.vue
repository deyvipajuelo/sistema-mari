<template>
  <section class="content">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
            
                <li class="breadcrumb-item"><a href="main">Inicio</a></li>
                
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-body row">
                        <div class="col-12 text-center d-flex align-items-center justify-content-center">
                            <div class="">
                                <h2>SIS<strong>GEA</strong></h2>
                                <h5>(Sistema de Gestión de Expedientes Administrativos)</h5>
                                <p class="lead mb-6">Desarrollado por:<br>
                                    Jhonatan V. Blas Revelo<br>
                                    Correo: JHTNBLAS61@GMAIL.COM<br><br>
                                    En cordinacion con la(el):<br>
                                    Abg. Janett Pineda Huayaney (Jefe de Unidad)<br>
                                    Abg. Ciro Ramírez Moreno (Responsable Archivo Central)<br><br>
                                    <b>Unidad de Servicios Judiciales</b><br>
                                    Archivo Central
                                </p>
                                <p class="lead mb-6">
                                    Corte Superior de Justicia de Ancash<br><br>
                                    <b>Copyright &copy; 2021</b>, Todo los Derechos Reservados
                                </p>
                            </div>
                        </div>
                    </div>
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
        data(){
            return {
                area_id: 0,
                
            }
        },
        computed:{
            
        },
        methods : {
        
        },
        mounted() {
            
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