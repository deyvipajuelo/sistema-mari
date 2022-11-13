<html>
<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Anexo 5</title>
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
            width: 650px; 
            height: auto;
            margin-left: auto;
            margin-right: auto;
        }
        .logo{
            border-width: 0.1rem;
            border-style: solid;
            vertical-align:middle;
            width: 25%;
            text-align: center;
        }
        .proceso{
            border-width: 0.1rem;
            border-style: solid;
            vertical-align:middle;
            width: 50%;
            text-align: center;
            
        }
        .pagina{
            border-width: 0.1rem;
            border-style: solid;
            vertical-align:middle;
            width: 17%;
            text-align: left;
        }
        .titulo{
            position: absolute;
            top: 7%;
            text-align: center; 
        }
        .contenido{
            width: auto; 
            height: auto;
            margin-left: 5%;
            margin-right: 3%;
            position: absolute;
            top: 13%;
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
            margin-left: 10%;
            margin-right: auto;
        }
        .footer{
            border: 1px solid rgb(0, 0, 0); 
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
    <div class="header">
        <table class="table table-bordered">
            <tr>
                <td class="logo"><img src="img/PJlogo.png" alt="Logo" width="150"></td>
                <td class="proceso" style="font-family: Calibri;font-size: 10px;"><p><b>PROCEDIMIENTO DE ATENCIÓN DE
                    <br>REQUERIMIENTOS INFORMÁTICOS DE LA CORTE
                    <br>SUPERIOR DE JUSTICIA DE ANCASH</b></p></td>
                <td class="pagina" style="font-family: Calibri;font-size: 9px;"><p> Código: P-SIS-01
                <br>Versión: 01
                <br>Pág.: 11 de 13</p></td>
            </tr>
        </table> 
        <div class="titulo">
            <h3>ANEXO N° 5</h3><br>
            <h3 style="position: absolute;top:5mm;margin-left:65mm;">BOLETA DE ATENCIÓN</h3>
            @foreach ($consulta as $c)
            <h3 style="position: absolute; display: inline-block;top:5mm;margin-left:120mm;">N° {{$c->numero}}</h3>
            @endforeach
        </div>
    </div>
    
    <div class="contenido">
        <div style="position:absolute;top:2mm;width:177mm;height:30mm; margin-left:0mm;">
            <label style="position:absolute; top:0mm;Calibri;font-size: 11px;" >INGRESO DE SOLICITUD</label>
            <div style="position:absolute;display: inline-block;top:0mm;width:5mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:50mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$s1}}</b></label>
            </div>
            <label style="position:absolute;display: inline-block; top:0mm;Calibri;font-size: 10px;margin-left:60mm;" >Telefónico</label>
            <div style="position:absolute;display: inline-block;top:0mm;width:5mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:80mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$s2}}</b></label>
            </div>
            <label style="position:absolute;display: inline-block; top:0mm;Calibri;font-size: 10px;margin-left:90mm;" >Correo Electrónico</label>
            <div style="position:absolute;display: inline-block;top:0mm;width:5mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:120mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$s3}}</b></label>
            </div>
            <label style="position:absolute;display: inline-block; top:0mm;Calibri;font-size: 10px;margin-left:130mm;" >Escrito</label>
            <div style="position:absolute;display: inline-block;top:0mm;width:5mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:150mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$s4}}</b></label>
            </div>
            <label style="position:absolute;display: inline-block; top:0mm;Calibri;font-size: 10px;margin-left:160mm;" >Personal</label>
            <br>
            <label style="position:absolute; top:6mm;font-family:Calibri;font-size: 11px;" ><b>DATOS DE USUARIO</b></label>
            <div style="position:absolute;top:11mm;width:176mm;height:15mm;border:1px solid;border-radius: 5px;margin-left:0mm;">
                <table style="position: absolute;top:1mm;">
                    @foreach ($consulta as $c)
                    <tr style="font-family:Calibri;font-size: 11px;">
                        <td width="120" style="border:none;">NOMBRE DE USUARIO</td>
                        <td width="380" colspan="3" style="border-radius: 5px;">{{$c->persona}}</td>
                    </tr>
                    <tr style="font-family:Calibri;font-size: 11px;">
                        <td style="border:none;">DEPENDENCIA</td>
                        <td width="180" style="border-radius: 5px;">{{$c->area}}</td>
                        <td width="20" style="border:none;">SEDE:</td>
                        <td style="border-radius: 5px;">{{$c->sede}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <h3 style="position: absolute;top:27mm;font-family:Calibri">ASISTENCIA TÉCNICA REALIZADA</h3>
        <div style="position:absolute;top:15%;width:40mm;height:50mm; margin-left:0mm;">
            <label for="" style="font-family: Calibri;font-size: 12px;"><b>SISTEMAS</b></label><br>
            <label style="font-family: Calibri;font-size: 10px;">SIJ</label>
            <div style="position:absolute;display: inline-block;top:2%;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:19mm;">
                <label style="font-family: Calibri;font-size: 12px;">{{$a1}}<b></b></label>
            </div>
            <br>
            <label style="position: absolute; top:10mm;Calibri;font-size: 10px;">SINOE</label>
            <div style="position:absolute;display: inline-block;top:10mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:23mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a2}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:16mm;Calibri;font-size: 10px;">SISCON OOJGU</label>
            <div style="position:absolute;display: inline-block;top:16mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:23mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a3}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:22mm;Calibri;font-size: 10px;">CERTIFICADO D.</label>
            <div style="position:absolute;display: inline-block;top:22mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:23mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a4}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:28mm;Calibri;font-size: 10px;">OTROS:</label>
            <p style="position:absolute;top:25mm;display: inline-block;font-family: Calibri;font-size: 10px;margin-left:12mm;">{{$a5}}</p>
            
        </div>
        <div style="position:absolute;display: inline-block;top:15%;width:50mm;height:50mm; margin-left:40mm;">
            <label for="" style="font-family: Calibri;font-size: 12px;"><b>REDES</b></label>
            <br><label style="font-family: Calibri;font-size: 10px;">USUARIO NOVELL</label>
            <div style="position:absolute;display: inline-block;top:2%;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:9mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a6}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:10mm;Calibri;font-size: 10px;">CORREO ELECTRONICO</label>
            <div style="position:absolute;display: inline-block;top:10mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:33mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a7}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:16mm;Calibri;font-size: 10px;">INTERNET</label>
            <div style="position:absolute;display: inline-block;top:16mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:33mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a8}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:22mm;Calibri;font-size: 10px;">CABLEADO</label>
            <div style="position:absolute;display: inline-block;top:22mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:33mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a9}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:28mm;Calibri;font-size: 10px;">ADQUISICIÓN</label>
            <div style="position:absolute;display: inline-block;top:28mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:33mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a10}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:34mm;Calibri;font-size: 10px;">OTROS:</label>
            <p style="position:absolute;top:31mm;display: inline-block;font-family: Calibri;font-size: 10px;margin-left:12mm;">{{$a11}}</p>
        </div>
        <div style="position:absolute;display: inline-block;top:15%;width:45mm;height:50mm; margin-left:90mm;">
            <label for="" style="font-family: Calibri;font-size: 12px;"><b>SOPORTE</b></label>
            <br><label style="font-family: Calibri;font-size: 10px;">INSTALACIÓN</label>
            <div style="position:absolute;display: inline-block;top:2%;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:9mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a12}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:10mm;Calibri;font-size: 10px;">CONFIGURACIÓN</label>
            <div style="position:absolute;display: inline-block;top:10mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:28mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a13}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:16mm;Calibri;font-size: 10px;">ANTIVIRUS</label>
            <div style="position:absolute;display: inline-block;top:16mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:28mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a14}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:22mm;Calibri;font-size: 10px;">MANTENIMIENTO</label>
            <div style="position:absolute;display: inline-block;top:22mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:28mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a15}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:28mm;Calibri;font-size: 10px;">ADQUISICIÓN</label>
            <div style="position:absolute;display: inline-block;top:28mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:28mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a16}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:34mm;Calibri;font-size: 10px;">OTROS:</label>
            <p style="position:absolute;top:31mm;display: inline-block;font-family: Calibri;font-size: 10px;margin-left:12mm;">{{$a17}}</p>
        </div>
        <div style="position:absolute;display: inline-block;top:15%;width:45mm;height:50mm; margin-left:135mm;">
            <label for="" style="font-family: Calibri;font-size: 12px;"><b>COMUNICACIÓN</b></label>
            <br><label style="font-family: Calibri;font-size: 10px;">INSTALACIÓN</label>
            <div style="position:absolute;display: inline-block;top:2%;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:7mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a18}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:10mm;Calibri;font-size: 10px;">CREACION CLAVES</label>
            <div style="position:absolute;display: inline-block;top:10mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:26mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a19}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:16mm;Calibri;font-size: 10px;">ALTAS</label>
            <div style="position:absolute;display: inline-block;top:16mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:26mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a20}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:22mm;Calibri;font-size: 10px;">CAMBIOS DE EQUI.</label>
            <div style="position:absolute;display: inline-block;top:22mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:26mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a21}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:28mm;Calibri;font-size: 10px;">AVERIAS</label>
            <div style="position:absolute;display: inline-block;top:28mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:26mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a22}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:34mm;Calibri;font-size: 10px;">TRASLADO</label>
            <div style="position:absolute;display: inline-block;top:34mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:26mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a23}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:40mm;Calibri;font-size: 10px;">ADQUSICIÓN</label>
            <div style="position:absolute;display: inline-block;top:40mm;width:15mm;height:5mm;border: 1px solid;border-radius: 5px;text-align: center; margin-left:26mm;">
                <label style="font-family: Calibri;font-size: 12px;"><b>{{$a24}}</b></label>
            </div>
            <br>
            <label style="position:absolute; top:46mm;Calibri;font-size: 10px;">OTROS:</label>
            <p style="position:absolute;top:43mm;display: inline-block;font-family: Calibri;font-size: 10px;margin-left:12mm;">{{$a25}}</p>
        </div>
        <div style="position:absolute;top:35%;">
            <h3>DESCRIPCIÓN DEL SERVICIO</h3>
            <div style="position:absolute;top:6%;width:177mm;height:20mm;border: 1px solid; margin-left:0mm;border-radius: 5px;">
                @foreach ($consulta as $c)
                <p style="font-family: Calibri;font-size: 12px;text-align: justify; padding:5px;">
                {{$c->descripcion}}</p>
                @endforeach
            </div>
        </div>
        <div style="position: absolute;top:50%;width:80mm;height:35mm;border:1px solid;border-radius: 5px;margin-left:0mm;">
            <table style="position: absolute;top:4mm;">
                @foreach ($consulta as $c)
                <tr style="font-family: Calibri;font-size:12px;">
                    <td style="border:none;">INICIO</td><td width="1" style="border:none;">:</td>
                    <td width="145" style="border:none;">{{$c->fecha_inicio}}</td>
                </tr>
                <tr><td style="border:none;"></td><td style="border:none;"></td></tr>
                <tr style="font-family: Calibri;font-size:12px;">
                    <td style="border:none;">FIN</td><td style="border:none;">:</td>
                    <td style="border:none;">{{$c->fecha_fin}}</td>
                </tr>
                <tr><td style="border:none;"></td><td style="border:none;"></td></tr>
                <tr style="font-family: Calibri;font-size:12px;">
                    <td style="border:none;">ATENDIDO POR</td><td style="border:none;">:</td>
                    <td style="font-family: Calibri;font-size:11px;border:none;">{{$c->responsable}}</td>
                </tr>
                @endforeach
            </table>
        </div>
        <div style="position: absolute;display:inline-block;top:50%;width:90mm;height:35mm;border:1px solid;border-radius: 5px;text-align: center; margin-left:87mm;">
            @foreach ($consulta as $c)
                @if ($c->firma=='')
                    <br><br><br><br><br><br>
                    <p><img src="" width="70" height="70" alt="Firma del solicitante"><hr width="210">FIRMA Y SELLO DE CONFORMIDAD DEL SOLICITANTE</p>
                @else
                    <p><img src=".{{$c->firma}}" width="70" height="70" alt="Firma del solicitante"><hr width="210">FIRMA Y SELLO DE CONFORMIDAD DEL SOLICITANTE</p> 
                @endif
            @endforeach
        </div>
       
        <div style="position:relative;top:76%;">
            <p>P-SIS-01-F04.Rev 02</p>
        </div>
    </div>
    <br>
    <div class="column-footer">
        
        <br><br><br><br><br>
        <div class="footer">
          <p class="pie">
            Prohibida su reproducción sin autorización del Representante de la dirección 
            </p>  
        </div>
    </div>
    
</body>
</html>
