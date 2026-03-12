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
        <h2>Prospectos</h2>
        <h3>General</h3>
        <table>
            <thead>
              <tr><th colspan="14">{{$hoy}}</th></tr>
                    <th>Plantel</th><th>Usuario</th><th>Leads Creados</th><th>Leads Prospectos</th>
                    <th>Clientes Concretados</th>
                    <th>Prosp. Nuevos</th><th>Prosp. Tocados</th><th>Avisos Creados</th><th>Avisos Cerrados</th>
                    <th>Informes Presenciales</th>
                    <th>Llamadas Efectivas</th><th>Llamadas No Efectivas</th>
                    <th>Cita Plantel</th>
                    <th>Base Total</th>
            </thead>
            <tbody>
            @foreach ($resumen as $registro)
            <tr>
                <td>
                  <a href=" {{route('prospectos.detalleProspectosTareasAvisosR',[
                    'plantel'=>$registro['plantel_id'], 
                    'user'=>$registro['user_id'],
                    'ayer'=>$registro['ayer'],
                    'hoy'=>$registro['hoy'],
                    'empleado'=>$registro['empleado_id'],
                    'inicio_matricula'=>$registro['inicio_matricula']
                    ]) }}" target="_blank">
                  {{ $registro['plantel'] }}
                  </a>
                </td>
                <td>{{ $registro['usuario'] }}</td>
                <td>{{ $registro['leads_creados'] }}</td><td>{{ $registro['leads_prospecto'] }}</td>
                <td>{{ $registro['clientes_concretados'] }}</td>
                <td>{{ $registro['prospectos_creados'] }}</td><td>{{ $registro['prospectos_tocados'] }}</td>
                <td>{{ $registro['avisos_creados'] }}</td><td>{{ $registro['avisos_cerrados'] }}</td><td>{{ $registro['tarea_informe_presencial'] }}</td>
                <td>{{ $registro['tarea_llamada_efectiva'] }}</td><td>{{ $registro['tarea_llamada_no_efectiva'] }}</td>
                <td>{{ $registro['tarea_cita_plantel'] }}</td><td>{{ $registro['base_total'] }}</td> 
                
            </tr>
            @endforeach
        
            </tbody>
        
    </div>
    
  </body>
</html>
