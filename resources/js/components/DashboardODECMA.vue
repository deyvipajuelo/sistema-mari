<template>
  <section class="content"> 
    <template v-if="vista==0">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <h1 class="m-0">SISTEMA DE GESTIÓN DE EXPEDIENTES ADMINISTRATIVOS (SISGEA)</h1>
            </div><!-- /.col -->
            
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div> 

      <div class="container-fluid">
        <div class="row">
          
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{total_expediente}}</h3>

                <p>Expediente</p>
              </div>
              <div class="icon">
                <i class="ion ion-clipboard"></i>
              </div>
              <a href="#" @click="abrirFormulario(2)" class="small-box-footer">Abrir <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
              <div class="inner">
                <h3 >{{total_legajo}}</h3>

                <p>Legajos</p>
              </div>
              <div class="icon">
                <i class="ion ion-document-text"></i>
              </div>
              <a href="#" @click="abrirFormulario(5)" class="small-box-footer">Abrir <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        </div>
      </div>
    </template>
    <template v-if="vista==1">
      <ingreso :ruta="ruta"></ingreso>
    </template>
    <template v-if="vista==2">
      <expediente :ruta="ruta"></expediente>
    </template>
    <template v-if="vista==5">
      <legajo :ruta="ruta"></legajo>
    </template>
  </section>
</template>

<script>
import ingreso from './Ingreso.vue'
import expediente from './Expediente.vue'
import legajo from './Legajo.vue'

    export default {
      props: ['ruta'],
      components: {
        ingreso,
        expediente,
        legajo
        
        
      },
        data(){
            return {
                ingreso: 0,
                total_expediente: 0,
                vista: 0,
                total_legajo:0
            }
        },
        computed:{
            isActived: function(){
               
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
            obtenerIngreso(){
                let me=this;
                var arrayT=[];
                var tot1=0;
                var url=me.ruta + '/ingreso/obtenerTotal1';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    arrayT = respuesta.consulta;
                    tot1 = arrayT[0]['total'];
                    me.ingreso=tot1;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            obtenerExpediente1(){
                let me=this;
                var arrayT=[];
                var tot1=0;
                var url=me.ruta + '/expediente/obtenerTotal1';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    arrayT = respuesta.consulta;
                    tot1 = arrayT[0]['total'];
                    me.total_expediente=tot1;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            
            obtenerLegajo(){
                let me=this;
                var arrayT=[];
                var tot1=0;
                var url=me.ruta + '/legajo/obtenerTotal';
                axios.get(url).then(function (response) {
                   // console.log(response);
                    var respuesta=response.data;
                    arrayT = respuesta.consulta;
                    tot1 = arrayT[0]['total'];
                    me.total_legajo=tot1;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            abrirFormulario(num){
              this.vista=0;
              var n=parseInt(num);
              if(n==1){
                this.vista=1;
              }else{
                if(n==2){
                  this.vista=2;
                }else{
                  this.vista=5;
                  
                }
              }
            }
        },
        mounted() {
            this.obtenerIngreso();
            this.obtenerExpediente1();
            this.obtenerLegajo();
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