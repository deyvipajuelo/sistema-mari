<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte desarchivados</title>
    <link rel="stylesheet" href="https://cdn.usebootstrap.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    <!-- <div class="card-body table-responsive p-1"> -->
    <div class="card-header">
        Reporte de expedientes desarchivados
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>N° Ingreso</th>
                <th>Expediente</th>
                <th>Materia/Delito</th>
                <th>A</th>
                <th>P</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($items as $item)
            <tr>
                <td>{{$item->numero_ingreso}}</td>
                <td>{{$item->expediente}}</td>                                  
                <td ><textarea style="word-break: break-all;height: auto; resize: none;width:100%;font-size: 12px;font-family: monospace; "readonly>{{$item->parteprocesal}}</textarea></td>
                <td>{{$item->anaquel}}</td>
                <td>{{$item->paquete}}</td>
                <td><textarea style="word-break: break-all;height: auto; resize: none;width:100%;font-size: 12px;font-family: monospace; " v-text="registro.motivo" readonly>{{$item->motivo}}</textarea></td>
                <td>
                    <span class="badge badge-danger">{{$item->estado}}</span>
                </td>
                <td>{{$item->created_at}}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="8">
                        No hay registros
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
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