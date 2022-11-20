<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/4.1.3/css/bootstrap.min.css"> -->
</head>
<body>
    <div class="card-header">
        Reporte de ingresos
    </div>
        <table class="table table-bordered text-nowrap">
            <thead>
                <tr>
                    <th rowspan="2">Item</th>
                    <th rowspan="2">Paquete</th>
                    <th rowspan="2">Cod. Archivo</th>
                    <th rowspan="2">Exp. Origen</th>
                    <th rowspan="2">Instancias</th>
                    <th rowspan="2">Especialidad</th>
                    <th rowspan="2">Tipo</th>
                    <th rowspan="2">Fech. Regist.</th>
                    <th rowspan="2">Local</th>
                    <th colspan="2">Ubicacion</th>
                    <tr>
                        <th>A</th>
                        <th>P</th>
                    </tr>
                </tr>
            </thead>
            <tbody>
                @forelse ($items as $item)
                <tr>
                    <td>{{$item->contador}}</td>
                    <td>{{$item->numero_ingreso}}</td>
                    <td>{{$item->codigo}}</td>
                    <td>{{$item->expediente}}</td>
                    <td>{{$item->instancia}}</td>
                    <td>{{$item->especialidad}}</td>
                    <td>{{$item->tipoarchivo}}</td>
                    <td>{{$item->fecha_registro}}</td>
                    <td>{{$item->nombre_local}}</td>
                    <td>{{$item->anaquel}}</td>
                    <td>{{$item->paquete}}</td>
                </tr>
                @empty
                    <tr>
                        <td colspan="11">
                            No hay registros
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    <!-- </div> -->
</body>
</html>

<style>
    th {
        font-size: 13px
    }
    td {
        font-size: 13px
    }
</style>