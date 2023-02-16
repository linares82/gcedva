<html>
  <head>
      <style>
        h1, h3, h4, h5, th { text-align: center; font-family: Segoe UI;}
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    
    
  </head>
  <body>
    <div class="datagrid">
        <h2>Detalle</h2>
        
        <h3>Call Center A Asesores</h3>
        <table>
            <thead>
                    <th>Plantel</th><th>Prospecto Id</th><th>St. Anterior</th><th>St. Despues</th>
                    <th>Creado El</th><th>U. Alta</th>
            </thead>
            <tbody>
            @foreach ($callToAsesorAyer as $ca)
            <tr>
                <td>{{ $ca->razon }}</td><td>{{ $ca->id }}</td>
                <td>{{ $ca->estatus_aterior }}</td><td>{{ $ca->estatus_despues }}</td>
                <td>{{ $ca->created_at }}</td><td>{{ $ca->usu_alta }}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>
        
        <h3>Clientes</h3>
        <table>
            <thead>
                    <th>Plantel</th><th>Cliente Id</th><th>Creado el</th><th>Estatus</th>
                    <th>Empleado</th>
            </thead>
            <tbody>
            @foreach ($clientes as $cliente)
            @if(is_null($cliente->reactivado))
            <tr>
                <td>{{ $cliente->razon }}</td><td>{{ $cliente->id }}</td>
                <td>{{ $cliente->fecha }}</td><td>{{ $cliente->estatus }}</td>
                <td>{{ $cliente->empleado }}</td>
            </tr>
            @endif
            @endforeach
        
            </tbody>
        </table>
        <br>
        <h3>Prospectos Convertidos</h3>
        <table>
            <thead>
                    <th>Plantel</th><th>Prospecto Id</th><th>Cliente Id</th>
                    <th>U. Alta</th>
            </thead>
            <tbody>
            @foreach ($prospectos_convertidos as $prospecto_convertido)
            <tr>
                <td>{{ $prospecto_convertido->razon }}</td><td>{{ $prospecto_convertido->id }}</td>
                <td>{{ $prospecto_convertido->cliente_id }}</td>
                <td>{{ $prospecto_convertido->name }}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>
        <br>
        <h3>Prospectos Nuevos</h3>
        <table>
            <thead>
                    <th>Plantel</th><th>Prospecto Id</th><th>Creado el</th>
                    <th>U. Alta</th>
            </thead>
            <tbody>
            @foreach ($prospectos_creados as $prospecto_creado)
            <tr>
                <td>{{ $prospecto_creado->razon }}</td><td>{{ $prospecto_creado->id }}</td>
                <td>{{ $prospecto_creado->created_at }}</td><td>{{ $prospecto_creado->usu_alta }}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>
        <br>
        <h3>Prospectos Tocados</h3>
        <table>
            <thead>
                    <th>Plantel</th><th>Prospecto Id</th>
                    <th>Accion</th><th>Tipo</th><th>Detalle</th>
                    <th>Creado el</th>
                    <th>U. Alta</th>
            </thead>
            <tbody>
            @foreach ($prospectos_tocados as $prospecto_tocado)
            <tr>
                <td>{{ $prospecto_tocado->razon }}</td><td>{{ $prospecto_tocado->id }}</td>
                <td>{{ $prospecto_tocado->tarea }}</td><td>{{ $prospecto_tocado->asunto }}</td>
                <td>{{ $prospecto_tocado->detalle }}</td>
                <td>{{ $prospecto_tocado->created_at }}</td><td>{{ $prospecto_tocado->usu_alta }}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>
        <br>
        <h3>Avisos Creados</h3>
        <table>
            <thead>
                    <th>Plantel</th><th>Prospecto Id</th><th>Activo</th><th>Detalle</th><th>Creado el</th>
                    <th>U. Alta</th>
            </thead>
            <tbody>
            @foreach ($avisos_creados as $aviso_creado)
            <tr>
                <td>{{ $aviso_creado->razon }}</td><td>{{ $aviso_creado->id }}</td>
                <td>{{$aviso_creado->activo==1 ? 'SI' : 'NO'}}</td>
                <td>{{ $aviso_creado->detalle }}</td><td>{{ $aviso_creado->created_at }}</td>
                <td>{{ $aviso_creado->name }}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>
        <br>
        <h3>Avisos Cerrados</h3>
        <table>
            <thead>
                    <th>Plantel</th><th>Prospecto Id</th><th>Activo</th><th>Detalle</th><th>Creado el</th>
                    <th>U. Alta</th>
            </thead>
            <tbody>
            @foreach ($avisos_cerrados as $aviso_cerrado)
            <tr>
                <td>{{ $aviso_cerrado->razon }}</td><td>{{ $aviso_cerrado->id }}</td><td>{{$aviso_cerrado->activo==1 ? 'SI' : 'NO'}}</td>
                <td>{{ $aviso_cerrado->detalle }}</td><td>{{ $aviso_cerrado->created_at }}</td>
                <td>{{ $aviso_cerrado->name }}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>
        <h3>Tareas</h3>
        <table>
            <thead>
                    <th>Plantel</th><th>Prospecto Id</th><th>Tarea</th><th>Creado el</th>
                    <th>U. Alta</th>
            </thead>
            <tbody>
            @foreach ($tareas as $tarea)
            <tr>
                <td>{{ $tarea->razon }}</td><td>{{ $tarea->id }}</td>
                <td>{{ $tarea->prospecto_tarea }}</td><td>{{ $tarea->created_at }}</td>
                <td>{{ $tarea->usu_alta }}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>

        <h3>Base Total</h3>
        <table>
            <thead>
                    <th>Plantel</th><th>Prospecto Id</th><th>Estatus</th><th>Creado el</th>
                    <th>U. Alta</th>
            </thead>
            <tbody>
            @foreach ($base_total as $base)
            <tr>
                <td>{{ $base->razon }}</td><td>{{ $base->id }}</td>
                <td>{{ $base->estatus }}</td><td>{{ $base->created_at }}</td>
                <td>{{ $base->usu_alta }}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>
    </div>
    
  </body>
</html>
