@extends('principal')
@section('contenido')
    @if(Auth::check())
        @if(Auth::user()->idrol==1)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>
            <template v-if="menu==1">
                <sede :ruta="ruta"></sede>
            </template>
            <template v-if="menu==2">
                <perfil :ruta="ruta"></perfil>
            </template>
            <template v-if="menu==3">
                <tipopersonal :ruta="ruta"></tipopersonal>
            </template>
            <template v-if="menu==4">
                <personal :ruta="ruta"></personal>
            </template>
            <template v-if="menu==5">
                <area1 :ruta="ruta"></area1>
            </template>
            <template v-if="menu==6">
                <instancia :ruta="ruta"></instancia>
            </template>
            <template v-if="menu==7">
                <persona :ruta="ruta"></persona>
            </template>
            <template v-if="menu==8">
                <rol :ruta="ruta"></rol>
            </template>
            <template v-if="menu==9">
                <user :ruta="ruta"></user>
            </template>
            <template v-if="menu==10">
                <estado :ruta="ruta"></estado>
            </template>
            <template v-if="menu==11">
                <tipoexpediente :ruta="ruta"></tipoexpediente>
            </template>
            <template v-if="menu==12">
                <tipoarchivo :ruta="ruta"></tipoarchivo>
            </template>
            <template v-if="menu==13">
                <tipoconclusion :ruta="ruta"></tipoconclusion>
            </template>
            <template v-if="menu==14">
                <especialidad :ruta="ruta"></especialidad>
            </template>
            <!-- MANTENIMIENTO DE TABLAS PARA REGISTRO DE PAQUETE -->
            <template v-if="menu==15">
                <distritojudicial :ruta="ruta"></distritojudicial>
            </template>
            <template v-if="menu==16">
                <provinciajudicial :ruta="ruta"></provinciajudicial>
            </template>
            <template v-if="menu==17">
                <localjudicial :ruta="ruta"></localjudicial>
            </template>
            <template v-if="menu==18">
                <organojudicial :ruta="ruta"></organojudicial>
            </template>
            <template v-if="menu==19">
                <instanciajudicial :ruta="ruta"></instanciajudicial>
            </template>
            <template v-if="menu==20">
                <local :ruta="ruta"></local>
            </template>
            <!-- INGRESO -->
            <template v-if="menu==21">
                <ingreso :ruta="ruta"></ingreso>
            </template>
            <!-- EXPEDIENTE -->
            <template v-if="menu==23">
                <expediente :ruta="ruta"></expediente>
            </template>
            <template v-if="menu==24">
                <clasepersona :ruta="ruta"></clasepersona>
            </template>
            <template v-if="menu==25">
                <parteprocesal :ruta="ruta"></parteprocesal>
            </template>
            <template v-if="menu==26">
                <materia :ruta="ruta"></materia>
            </template>
             <!-- VERIFICAR -->
             <template v-if="menu==27">
                <verificar :ruta="ruta"></verificar>
            </template>
            <!-- BUSCAR -->
            <template v-if="menu==28">
                <buscar :ruta="ruta"></buscar>
            </template>
            <!-- CONTACTO -->
            <template v-if="menu==29">
                <contacto :ruta="ruta"></contacto>
            </template>
            <!-- CAMBIAR CONTRASEÑA DE USUARIO -->
            <template v-if="menu==22">
                <cambiarclave :ruta="ruta"></cambiarclave>
            </template>
             <!-- Legajo -->
             <template v-if="menu==30">
                <legajo :ruta="ruta"></legajo>
            </template>
            <!-- reporte ingreso -->
            <template v-if="menu==31">
                <reporteingreso :ruta="ruta"></reporteingreso>
            </template>
             <!-- desarchivar -->
             <template v-if="menu==32">
                <desarchivar :ruta="ruta"></desarchivar>
            </template>
            <!-- Registro de expedientes en ODECMA -->
            <template v-if="menu==33">
                <expedienteOdecma :ruta="ruta"></expedienteOdecma>
            </template>
        @elseif (Auth::user()->idrol==2)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>
            
            <!-- INGRESO -->
            <template v-if="menu==21">
                <ingreso :ruta="ruta"></ingreso>
            </template>
            <!-- EXPEDIENTE -->
            <template v-if="menu==23">
                <expediente :ruta="ruta"></expediente>
            </template>
            
            <!-- VERIFICAR -->
            <template v-if="menu==27">
                <verificar :ruta="ruta"></verificar>
            </template>
            <!-- BUSCAR -->
            <template v-if="menu==28">
                <buscar :ruta="ruta"></buscar>
            </template>
            <!-- CONTACTO -->
            <template v-if="menu==29">
                <contacto :ruta="ruta"></contacto>
            </template>
            <!-- CAMBIAR CONTRASEÑA DE USUARIO -->
            <template v-if="menu==22">
                <cambiarclave :ruta="ruta"></cambiarclave>
            </template>
            <!-- Legajo -->
            <template v-if="menu==30">
                <legajo :ruta="ruta"></legajo>
            </template>
             <!-- reporte ingreso -->
             <template v-if="menu==31">
                <reporteingreso :ruta="ruta"></reporteingreso>
            </template>
             <!-- desarchivar -->
             <template v-if="menu==32">
                <desarchivar :ruta="ruta"></desarchivar>
            </template>
        @elseif (Auth::user()->idrol==3)
            <!-- DASHBOARD PARA ODECMA -->
            <template v-if="menu==0">
                <dashboard1 :ruta="ruta"></dashboard1>
            </template>
            <!-- INGRESO -->
           
            <!-- EXPEDIENTE -->
            <template v-if="menu==33">
                <expedienteodecma :ruta="ruta"></expedienteodecma>
            </template>
            <!-- CONTACTO -->
            <template v-if="menu==29">
                <contacto :ruta="ruta"></contacto>
            </template>
            <!-- CAMBIAR CONTRASEÑA DE USUARIO -->
            <template v-if="menu==22">
                <cambiarclave :ruta="ruta"></cambiarclave>
            </template>
            <!-- Legajo -->
            <template v-if="menu==30">
                <legajo :ruta="ruta"></legajo>
            </template>
        @elseif (Auth::user()->idrol==4)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>
            <!-- MANTENIMIENTO DE TABLAS PARA REGISTRO DE PAQUETE -->
            
            <!-- INGRESO -->
            <template v-if="menu==21">
                <ingreso :ruta="ruta"></ingreso>
            </template>
            <!-- EXPEDIENTE -->
            <template v-if="menu==23">
                <expediente :ruta="ruta"></expediente>
            </template>
            <template v-if="menu==24">
                <clasepersona :ruta="ruta"></clasepersona>
            </template>
            <template v-if="menu==25">
                <parteprocesal :ruta="ruta"></parteprocesal>
            </template>
            <template v-if="menu==26">
                <materia :ruta="ruta"></materia>
            </template>
            <!-- VERIFICAR -->
            <template v-if="menu==27">
                <verificar :ruta="ruta"></verificar>
            </template>
            <!-- BUSCAR -->
            <template v-if="menu==28">
                <buscar :ruta="ruta"></buscar>
            </template>
            <!-- CONTACTO -->
            <template v-if="menu==29">
                <contacto :ruta="ruta"></contacto>
            </template>
            <!-- CAMBIAR CONTRASEÑA DE USUARIO -->

            <template v-if="menu==22">
                <cambiarclave :ruta="ruta"></cambiarclave>
            </template>
            <!-- Legajo -->
            <template v-if="menu==30">
                <legajo :ruta="ruta"></legajo>
            </template>
            <!-- reporte ingreso -->
            <template v-if="menu==31">
                <reporteingreso :ruta="ruta"></reporteingreso>
            </template>
            <!-- desarchivar -->
            <template v-if="menu==32">
                <desarchivar :ruta="ruta"></desarchivar>
            </template>
            
        @else
        @endif 
    @endif

    
@endsection