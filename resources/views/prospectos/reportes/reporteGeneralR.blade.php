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
        <h2>Actividades de Prospectos</h2>
        <h3>Resumen</h3>
        <table>
            <thead>
                    <th>Colaborardor</th><th>Actividad</th><th>Cantidad</th>
            </thead>
            <tbody>
            @foreach ($resumen_totales as $reg)
            
            <tr>
                <td>{{$reg['empleado']}}</td><td>{{$reg['actividad']}}</td><td>{{$reg['cantidad']}}</td>
            </tr>
            @endforeach
            @foreach ($resumen_nuevos as $reg)
            <tr>
                <td>{{$reg['empleado']}}</td><td>{{$reg['actividad']}}</td><td>{{$reg['cantidad']}}</td>
            </tr>
            @endforeach
            @foreach ($resumen_aceptados as $reg)
            <tr>
                <td>{{$reg['empleado']}}</td><td>{{$reg['actividad']}}</td><td>{{$reg['cantidad']}}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>
        
        <h3>Detalle Actividades</h3>
        <table>
            <thead>
                    <th>Actividad</th><th>Prospecto</th><th>T. Celular</th><th>Mail</th>
                    <th>Plantel</th><th>Estatus P.</th><th>Estatus S.</th><th>Empleado</th>
                    <th>Tarea</th><th>Asunto</th><th>Estatus A.</th><th>Detalle</th>
                    <th>Fecha</th><th>Creado el</th>
            </thead>
            <tbody>
            @foreach ($avisos as $registro)
            <tr>
                <td>
                  @if($registro->bnd_tarea==0)
                    Aviso
                  @elseif($registro->bnd_tarea==1)
                    Tarea
                  @endif
                </td>
                <td>{{ $registro->nombre }}</td><td>{{ $registro->tel_cel }}</td>
                <td>{{ $registro->mail }} </td><td>{{ $registro->razon }} </td> <td>{{$registro->st_prospecto}}</td>
                <td>{{$registro->st_seguimiento}}</td><td>{{$registro->empleado}}</td><td>{{$registro->tarea}}</td>
                <td>{{$registro->asunto}}</td>
                <td>
                    {{$registro->st_tarea}}  
                </td>
                <td>{{$registro->detalle}}</td><td>{{$registro->fecha}}</td>
                <td>{{$registro->created_at}}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>

        <h3>Detalle Prospectos Creados</h3>
        <table>
            <thead>
                    <th>Id</th><th>Prospecto</th><th>T. Celular</th><th>Mail</th>
                    <th>Plantel</th><th>Estatus P.</th><th>Estatus S.</th><th>Empleado</th>
                    <th>Creado el</th>
            </thead>
            <tbody>
            @foreach ($prospectos_nuevos as $registro)
            <tr>
                <td>
                  {{$registro->id}}
                </td>
                <td>{{ $registro->nombre }}</td><td>{{ $registro->tel_cel }}</td>
                <td>{{ $registro->mail }} </td><td>{{ $registro->razon }} </td> <td>{{$registro->st_prospecto}}</td>
                <td>{{ $registro->st_seguimiento}}</td><td>{{$registro->empleado}}</td>
                <td>{{ $registro->created_at}}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>
        
        <h3>Detalle Prospectos Aceptados</h3>
        <table>
            <thead>
                    <th>Id</th><th>Prospecto</th><th>T. Celular</th><th>Mail</th>
                    <th>Plantel</th><th>Estatus P.</th><th>Estatus S.</th><th>Empleado</th>
                    <th>Aceptado el</th>
            </thead>
            <tbody>
            @foreach ($prospectos_clientes as $registro)
            <tr>
                <td>
                  {{$registro->id}}
                </td>
                <td>{{ $registro->nombre }}</td><td>{{ $registro->tel_cel }}</td>
                <td>{{ $registro->mail }} </td><td>{{ $registro->razon }} </td> <td>{{$registro->st_prospecto}}</td>
                <td>{{ $registro->st_seguimiento}}</td><td>{{$registro->empleado}}</td>
                <td>{{ $registro->created_at}}</td>
            </tr>
            @endforeach
        
            </tbody>
        </table>

    </div>
    
  </body>
</html>
