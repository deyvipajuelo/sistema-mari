<html>
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="img/LogoPj.png">
    <title>Reporte</title>
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
            margin-left: 0%;
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
            top: 12%;

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
    @foreach ($padre as $p)
    <div style="page-break-after:always;">
        <div class="header">
            <table class="table table-bordered">
                <tr>
                    <td class="logo"><img src="img/PJlogo.png" alt="Logo" width="180">Corte Superior de Justicia de Ancash<br>Sede Huaraz</td>
                    @foreach($p[1] as $d5)
                    <td class="proceso" width="500" style="text-align: center;">
                        <div style="position:absolute;top:2mm;height: 16mm;border:none;text-align: center;margin-left: 33mm;">
                            {!! DNS1D::getBarcodeHTML($d5->numero_ingreso, 'C39') !!}
                            <span style="font-family: Calibri;font-size: 18px;">
                                {{$d5->numero_ingreso}}</span> </div>
                        </div>
                        </td>
                    @endforeach 
                    <td class="pagina" width="150"><p>
                    &nbsp;&nbsp;Versión: 01
                    <br>
                    &nbsp;&nbsp;Pág.: {{$p[2]}} de {{$p[3]}}
                    <br>
                    @foreach($p[1] as $d1)
                    &nbsp;&nbsp;{{$d1->fecha}}
                        
                    @endforeach 
                    
                    </p>
                    </td>
                </tr>
            </table> 

        </div>
        <div class="contenido">
            <div  style="position:absolute;top:0mm;width:85%;height:10%;border: none;display: inline-block;">
                <div  style="display: inline-block;width:100%;height:10%;border:none;margin-left: 5%;">
                    <div class="titulo">
                            <h3>LISTADO DE EXPEDIENTES PARA ARCHIVO GENERAL</h3>
                    </div>
                </div>
                <div  style="position: absolute;display: inline-block;top: 0mm;width:50mm;height:16mm;border:none;margin-left: 0mm;">
                    @foreach($p[6] as $d2)
                        <label for="" style="position: absolute;top: 1mm;display: inline-block;font-family: Calibri;font-size: 11px;"><b>ANAQUEL:</b></label>
                        <div  style="top: 1mm;width:10mm;height:5mm;border: 1px solid #000000;display: inline-block;border-radius: 5px;
                            position: absolute;margin-left: 16mm; text-align: center;">
                            <label for="" style="position: relative;top: 0mm;padding:2mm;font-family: Calibri;font-size: 14px;">{{$d2->anaquel}}</label>
                        </div>
                        <label for="" style="position: absolute;top: 9mm;display: inline-block;font-family: Calibri;font-size: 11px;"><b>PAQUETE:</b></label>
                        <div  style="top: 9mm;width:10mm;height:5mm;border: 1px solid #000000;display: inline-block;border-radius: 5px;
                            position: absolute;margin-left: 16mm;text-align: center;">
                            <label for="" style="position: relative;top: 0mm;padding:2mm;font-family: Calibri;font-size: 14px;">{{$d2->paquete}}</label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div style="position:absolute;top:15mm;width:100%;height:auto;border: none;display: inline-block;margin-left: 0mm;">
                @foreach($p[1] as $d3)
                    <div style="position:relative;top:15mm;width:100%;height:12mm;border: none;display: inline-block;margin-left: 0mm;">
                        <label style="position: absolute;top: 1mm;display: inline-block;font-family: Calibri;font-size: 14px;margin-left: 0mm;">DISTRITO JUDICIAL:</label>
                        <label style="position: absolute;top: 1mm;display: inline-block;font-family: Calibri;font-size: 14px;margin-left: 37mm;">{{$d3->distrito}}</label>
                        <label style="position: absolute;top: 1mm;display: inline-block;font-family: Calibri;font-size: 14px;margin-left: 90mm;">INSTANCIA:</label>
                        <label style="position: absolute;top: 1mm;display: inline-block;font-family: Calibri;font-size: 14px;margin-left: 113mm;">{{$d3->instancia}}</label>
                        <label style="position: absolute;top: 1mm;display: inline-block;font-family: Calibri;font-size: 14px;margin-left: 180mm;">PROVINCIA:</label>
                        <label style="position: absolute;top: 1mm;display: inline-block;font-family: Calibri;font-size: 14px;margin-left: 205mm;">{{$d3->provincia}}</label>
                    </div>
                @endforeach
                <table width="100%" style="border-collapse: collapse;">
                    <tr>
                        <th rowspan="2" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">Item
                        </th>
                        <th rowspan="2" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">Nro EXPEDIENTE
                        </th>
                        <th colspan="2" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">Materia
                        </th>
                        <th rowspan="2" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">Folios
                        </th>
                        <th rowspan="2" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">Delitos
                        </th>
                        <th rowspan="2" style="font-family: Arial;font-size: 10px;text-align: center;color:black;">ESTADO
                        </th>
                    </tr>
                    <tr>
                        <th style="font-family: Arial;font-size: 10px;text-align: center;color:black;">Demandante/Agraviado()<br>
                            (Paterno,Materno,Nombre)
                        </th>
                        <th style="font-family: Arial;font-size: 10px;text-align: center;color:black;">Demandado/Denunciado<br>
                            (Paterno,Materno,Nombre)
                        </th>
                    </tr>
                    <!-- LISTA DE REGISTROS -->
                    @foreach($p[0] as $d4)
                    <tr style="text-align: center;">
                        <td style=" border: inset 0pt;border-bottom: 1px solid black;">{{$d4->contador}}</td>
                        <td style=" border: inset 0pt;border-bottom: 1px solid black;">{{$d4->expediente}}</td>
                        <td style=" border: inset 0pt;border-bottom: 1px solid black;">{{$d4->demandante}}</td>
                        <td style=" border: inset 0pt;border-bottom: 1px solid black;">{{$d4->demandado}}</td>
                        <td style=" border: inset 0pt;border-bottom: 1px solid black;">{{$d4->numero_folio}}</td>
                        <td style=" border: inset 0pt;border-bottom: 1px solid black;">{{$d4->materia}}</td>
                        <td style=" border: inset 0pt;border-bottom: 1px solid black;">{{$d4->estado}}</td>
                    </tr>
                    @endforeach
                    <!-- FIN LISTA DE REGISTROS -->
                </table>
                <hr >

                <label style="position: absolute;display: inline-block;font-family: Calibri;font-size: 14px;margin-left: 10mm;"><b>Total de Expedientes por Instancia: {{$p[4]}}</b></label>
                <label style="position: absolute;display: inline-block;font-family: Calibri;font-size: 14px;margin-left: 171mm;"><b>Total de Folios: {{$p[5]}}</b></label>
            </div>
            
        </div>     
        <div class="column-footer">
            <div class="footer" style="position: relative;top:5mm;height: 5mm;text-align: center;">
                <label class="pie">
                Prohibida su reproducción sin autorización del Representante de la Dirección 
                </label>  
            </div>
        </div>
    </div>
    @endforeach
</body>
</html>