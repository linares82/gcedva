<html>
  <head>
      <style>
        h1, h5, h3, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    
  </head>
  <body>
      <h3>Inspección Vigilancia</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th></th><th>Plantel</th><th>Cliente Id</th><th>Nombre</th><th>Nivel</th><th>Grupo</th>
                    <th>Inscripción/Reinscripción</th><th>Primera Mensualidad</th><th>Asistencias</th><th>Cumple</th>
                </tr> 
            </thead>
            <tbody>
                <?php 
                $i=0; 
                $j=0;
                ?>
                <?php $grupo="" ?>
                <?php $contador_linea=1; ?>
                @foreach($registros as $registro)
                    
                    <tr>
                        <td>{{$contador_linea++}}</td>
                        <td>{{$registro['razon']}} </td>
                        <td>{{$registro['cliente_id']}}</td><td>{{$registro['nombre']}} </td>
                        <td>{{$registro['nivel']}}</td>
                        <td>{{$registro['grupo']}}</td>
                        <td>{{$registro['inscripcion']}}</td>
                        <td>{{$registro['primera_mensualidad']}}</td>
                        <td>{{$registro['asistencias']}}</td>
                        <td>{{$registro['cumple']}}</td>
                    </tr>
                    
                @endforeach
                    
            </tbody>
        </table>
    </div>
    
  </body>
</html>

