/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */
 import ElementUI from 'element-ui'
 import locale from 'element-ui/lib/locale/lang/en'
 Vue.use(ElementUI)
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.component('dashboard', require('./components/Dashboard.vue').default);
Vue.component('dashboard1', require('./components/DashboardODECMA.vue').default);
Vue.component('sede', require('./components/Sede.vue').default);
Vue.component('perfil', require('./components/Perfil.vue').default);
Vue.component('tipopersonal', require('./components/Tipopersonal.vue').default);
Vue.component('personal', require('./components/Personal.vue').default);
Vue.component('area1', require('./components/Area.vue').default);
Vue.component('instancia', require('./components/Instancia.vue').default);
Vue.component('persona', require('./components/Persona.vue').default);
Vue.component('rol', require('./components/Rol.vue').default);
Vue.component('user', require('./components/User.vue').default);
Vue.component('cambiarclave', require('./components/CambiarClave.vue').default);
Vue.component('select2', require('./components/Select2.vue').default);

Vue.component('estado', require('./components/Estado.vue').default);
Vue.component('tipoexpediente', require('./components/TipoExpediente.vue').default);
Vue.component('tipoarchivo', require('./components/TipoArchivo.vue').default);
Vue.component('tipoconclusion', require('./components/TipoConclusion.vue').default);
Vue.component('especialidad', require('./components/Especialidad.vue').default);
Vue.component('distritojudicial', require('./components/DistritoJudicial.vue').default);
Vue.component('provinciajudicial', require('./components/ProvinciaJudicial.vue').default);
Vue.component('localjudicial', require('./components/LocalJudicial.vue').default);
Vue.component('organojudicial', require('./components/OrganoJudicial.vue').default);
Vue.component('instanciajudicial', require('./components/InstanciaJudicial.vue').default);
Vue.component('local', require('./components/Local.vue').default);
Vue.component('ingreso', require('./components/Ingreso.vue').default);
Vue.component('expediente', require('./components/Expediente.vue').default);
Vue.component('expedienteodecma', require('./components/ExpedienteOdecma.vue').default);
Vue.component('clasepersona', require('./components/ClasePersona.vue').default);
Vue.component('parteprocesal', require('./components/ParteProcesal.vue').default);
Vue.component('materia', require('./components/Materia.vue').default);
Vue.component('verificar', require('./components/Verificar.vue').default);
Vue.component('buscar', require('./components/Buscar.vue').default);
Vue.component('legajo', require('./components/Legajo.vue').default);
Vue.component('reporteingreso', require('./components/ReporteIngreso.vue').default);
Vue.component('desarchivar', require('./components/Desarchivar.vue').default);
Vue.component('contacto', require('./components/Contacto.vue').default);


const app = new Vue({
    el: '#app',
    data :{
        menu:0,
        ruta: 'http://localhost/archivocentral/sisgea'
    }
});
