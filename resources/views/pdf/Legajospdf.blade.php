<html>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="img/LogoPj.png">
    <title>Reporte Legajo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <style type="text/css">
      body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif, sans-serif;
            font-size: 11px;
            font-weight: normal;
            line-height: 1.5;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        
        .table-bordered {
            border-width: 0.1rem;
            border-style: solid;
        }
        
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
        
        .header{
            width: auto; 
            height: auto;
            margin-left: 3%;
            margin-right: auto;
            flex-flow: column;
        }
        .logo{
            border-width: 0.1rem;
            border-style: solid;
            vertical-align:middle;
            width: 30%;
            text-align: center;
        }
        .proceso{
            border-width: 0.1rem;
            border-style: solid;
            vertical-align:middle;
            width: 100%;
            text-align: center;
            
        }
        .pagina{
            border-width: 0.1rem;
            border-style: solid;
            vertical-align:middle;
            width: 30%;
            text-align: left;
        }
        .titulo{
            text-align: center;
             
        }
        .contenido{
            width: auto; 
            height: auto;
            margin-left: 3%;
            margin-right: 3%;
            position: absolute;
            top: 5%;

        }
        th {
            border-width: 0.1rem;
            border-style: solid;
            font-weight: bold;
            text-align: -internal-center;
            text-align: center;
        }
        td {
            border-width: 0.1rem;
            border-style: solid;
        }
        
        .detalle{
            border-width: 0.1rem;
            border-style: solid;
            vertical-align:middle;
            text-align: center; 
        }
        .column-footer{
            position: absolute;
            bottom: 0;
            width: auto; 
            height: auto;
            margin-left: 5%;
            margin-right: auto;
            flex-flow: column;
        }
        .footer{
            border: 1px solid rgb(0, 0, 0);
            margin-left: 5%;
            margin-right: 10%; 
        }
        .pie{
            text-align: center;
            font-family: Arial;
            font-size: 10px;
            color: #000000;
        }
  </style>
</head>
<body>
    
    <div style="page-break-after:auto;">
        <div class="header">
            <div style="position:absolute;top:0mm;width:100%;height:5%;border: none;display: inline-block;">
                <img src="img/PJlogo.png" alt="Logo" width="180"><br>Corte Superior de Justicia de Ancash
            </div>
        </div>
        <div class="contenido">
            <div  style="position:absolute;top:0mm;width:100%;height:5%;border: none;">
                <div  style="width:100%;height:10%;border:none;margin-left: 5%;">
                    <div class="titulo">
                            <h3>LEGAJOS PARA REMITIR AL ARCHIVO - ODECMA</h3>
                    </div>
                </div>
                
            </div>
            <div style="position:absolute;top:15mm;width:100%;height:auto;border: none;display: inline-block;margin-left: 0mm;">
                @foreach($cabecera as $c1)
                    <div style="position:relative;top:15mm;width:100%;height:12mm;border: none;display: inline-block;margin-left: 0mm;">
                        <label style="position: absolute;top: 1mm;display: inline-block;font-family: Arial;font-size: 12px;margin-left: 0mm;"><b>DISTRITO JUDICIAL</b></label>
                        <label style="position: absolute;top: 1mm;display: inline-block;font-family: Arial;font-size: 12px;margin-left: 37mm;">: {{$c1->distrito}}</label>
                        <label style="position: absolute;top: 1mm;display: inline-block;font-family: Arial;font-size: 12px;margin-left: 140mm;"><b>ANAQUEL:</b></label>
                        <label style="position: absolute;top: 1mm;display: inline-block;font-family: Arial;font-size: 14px;margin-left: 160mm;">{{$c1->anaquel}}</label>
                        <label style="position: absolute;top: 6mm;display: inline-block;font-family: Arial;font-size: 12px;margin-left: 0mm;"><b>INSTANCIA</b></label>
                        <label style="position: absolute;top: 6mm;display: inline-block;font-family: Arial;font-size: 12px;margin-left: 37mm;">: {{$c1->instancia}}</label>
                        <label style="position: absolute;top: 6mm;display: inline-block;font-family: Arial;font-size: 12px;margin-left: 140mm;"><b>PAQUETE:</b></label>
                        <label style="position: absolute;top: 6mm;display: inline-block;font-family: Arial;font-size: 14px;margin-left: 160mm;">{{$c1->paquete}}</label>
                        <label style="position: absolute;top: 11mm;display: inline-block;font-family: Arial;font-size: 12px;margin-left: 0mm;"><b>PROVINCIA</b></label>
                        <label style="position: absolute;top: 11mm;display: inline-block;font-family: Arial;font-size: 12px;margin-left: 37mm;">: {{$c1->provincia}}</label>
                        <label style="position: absolute;top: 16mm;display: inline-block;font-family: Arial;font-size: 12px;margin-left: 0mm;"><b>ASUNTO</b></label>
                        <label style="position: absolute;top: 16mm;display: inline-block;font-family: Arial;font-size: 12px;margin-left: 37mm;">: {{$c1->asunto}}</label>
                    </div>
               @endforeach
                <table width="100%" style="border-collapse: collapse;position:relative;top:15mm;">
                    <tr>
                        <th width="15" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">N°</th>
                        <th  style="font-family: Arial;font-size: 10px;text-align: center;color:black;">DESCRIPCIÓN
                        </th>
                        <th width="140" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">OBSERVACIÓN
                        </th>
                        <th width="23" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">AÑO
                        </th>
                        <th width="35" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">FOLIOS
                        </th>
                        <th width="68" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">ESTADO
                        </th>
                    </tr>
                    
                    <!-- LISTA DE REGISTROS -->
                @foreach($consulta as $c2)
                    <tr style="text-align: center;">
                        <td style="font-family: Arial;font-size: 12px;text-align: center;color:black;">{{$c2->contador}}</td>
                        <td style=" font-family: Arial;font-size: 11px;text-align: justify;color:black;">{{$c2->descripcion}}</td>
                        <td style="font-family: Arial;font-size: 11px;text-align: center;color:black;">{{$c2->observacion}}</td>
                        <td style="font-family: Arial;font-size: 12px;text-align: center;color:black;">{{$c2->anio}}</td>
                        <td style="font-family: Arial;font-size: 12px;text-align: center;color:black;">{{$c2->folio}}</td>
                        <td style="font-family: Arial;font-size: 11px;text-align: center;color:black;">{{$c2->estado}}</td>
                        
                    </tr>
                @endforeach
                    <!-- FIN LISTA DE REGISTROS -->
                </table>
               

                
            </div>
            
        </div>     
        <div class="column-footer">
            
        </div>
    </div>
 
</body>
</html>