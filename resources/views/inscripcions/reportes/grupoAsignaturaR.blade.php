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
      <h3>Grupo Asignatura</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>RVOE</th><th>Ciclo Escolar</th><th>Periodo Escolar</th><th>CURP Alumno</th><th>Grupo</th><th>Tipo Movimiento</th>
                </tr> 
            </thead>
            <tbody>
                @foreach($registros as $registro)
                    <tr>
                        <td>{{$registro->rvoe}}</td>
                        <td>{{$registro->ciclo_escolar}}</td>
                        <td>{{$registro->periodo_escolar}}</td>
                        <td>{{$registro->curp}}</td>
                        <td>{{$registro->grupo_numero."0".$registro->orden.$registro->grupo_letra}}</td>
                        <td>A</td>
                    </tr>
                    
                @endforeach
                    
            </tbody>
        </table>
    </div>
    
  </body>
</html>

