<link href="../css/plantilla.css" rel="stylesheet">
@extends('errors::illustrated-layout')

@section('code', '404')
@section('title', __('Página no encontrada'))

@section('image')
    <style>
        
        
        .img{
            width: 100%;
            height: auto;
            text-align: center;
            background-image: url("../img/pjlogo.jpg");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center center;
            background-position: center center;
            background-color: #66999;
            background-size: 100%;
            
        }
    </style>
    <div id="img" class="img">
        <h2><i>Corte Superior de Justicia de Ancash</i> <br>"Archivo Central"</h2>
        
        
    </div>
    
@endsection

@section('message', __('No hemos encontrado la página que buscas.'))