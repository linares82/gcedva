<html>
  <head>
      <style>
        h1, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    
  </head>
  <body>
      <h3>Reprobados</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th></th><th>Plantel</th><th>Cliente</th><th>Estatus</th>
                    <th>Matricula</th>
                    <th>Lectivo</th><th>T. Examen</th><th>Materia</th>
                    <th>Calificacion</th>
                </tr> 
            </thead>
            <tbody>
                
                <?php $contador_linea=1; ?>
                @foreach($registros as $registro)
                    
                    <tr>
                        <td>{{$contador_linea++}}</td>
                        <td>{{$registro->plantel}}</td>
                        <td>{{$registro->cliente_id}} - {{$registro->nombre}} {{$registro->nombre2}} {{$registro->ape_paterno}} {{$registro->ape_materno}}</td>
                        <td>{{$registro->st_cliente}}</td>
                        <td>{{$registro->matricula}}</td>
                        <td>{{$registro->lectivo}}</td>
                        <td>{{$registro->tpo_examen}}</td>
                        <td>{{$registro->materia}}</td>
                        <td>{{$registro->calificacion}}</td>
                    </tr>
                    
                    
                @endforeach
                    
                    
            </tbody>
        </table>
    </div>
    
  </body>
</html>

