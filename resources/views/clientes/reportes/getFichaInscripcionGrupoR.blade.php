<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formato Inscripción</title>
    <style>
        h1, h2, H3, h4, h5, h6 th { text-align: center;font-family: Segoe UI; }
        /*table { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }*/
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
        
      </style>
</head>
<body style="padding:20px;font-family: Segoe UI;">
    <h4>Ficha de Inscripcion </h4>
    <h4>Alumnos encotrados </h4>
    <table class="table table-condensed table-striped">
        <thead>
            <th>Csc</th><th>Id</th><th>Cliente</th><th>Combinacion</th><th>Lectivo</th><th>Grupo</th><th></th>
        </thead>
        <tbody>
            @php
                $i=0;
            @endphp
            @foreach ($clientes as $cliente)
                <tr>
                    <td>{{ ++$i }}</td><td>{{$cliente->cliente_id}}</td>
                    <td>{{$cliente->nombre}} {{$cliente->nombre2}} {{$cliente->ape_paterno}} {{$cliente->ape_materno}}</td>
                    <td>
                        {{ $cliente->plantel }} - {{ $cliente->especialidad }} - {{ $cliente->nivel }} - 
                        {{ $cliente->grado }}
                    </td>
                    <td>{{$cliente->lectivo}}</td><td>{{$cliente->grupo}}</td>
                    <td><a class="btn btn-default btn-xs" href="{{ 
                        route('clientes.formatoFichaInscripcionIndividual', 
            array('cliente_id'=>$cliente->cliente_id,
                               'plantel_id'=>$cliente->plantel_id,
                               'especialidad_id'=>$cliente->especialidad_id,
                               'nivel_id'=>$cliente->nivel_id,
                               'grado_id'=>$cliente->grado_id,
                               'lectivo_id'=>$cliente->lectivo_id,
                               'grupo_id'=>$cliente->grupo_id)) }}">Imprimir</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>