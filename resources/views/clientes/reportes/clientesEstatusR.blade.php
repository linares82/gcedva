<html>
  <head>
      <style>
        h1, h3, h5, th { text-align: center; }
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
        <h3>Consulta de eventos de Bajas del {{$datos['fecha_f']}} al {{$datos['fecha_t']}}</h3>
        <table class="table table-condensed table-striped">
            <thead>
                <th>Plantel</th><th>Alumno</th><th>Fecha</th><th>Estatus</th><th>Tel.</th><th>Descripción</th>
            </thead>
            <tbody>
                <?php $cont=0; ?>
                @foreach($registros as $registro)
                <tr>
                    <td>{{ $registro->razon }}</td><td>{{$registro->cliente."-".$registro->nombre." ".$registro->ape_paterno." ".$registro->ape_materno}}</td>
                    <td>{{$registro->fecha}}</td><td>{{$registro->estatus}}</td><td>{{$registro->tel_fijo}}</td><td>{{$registro->descripcion}}</td>
                </tr>
                <?php $cont++; ?>
                @endforeach
                <tr><td colspan="3"><strong>Total</strong></td><td><strong>{{$cont}}</strong></td</tr>
            </tbody>
        </table>
    </div>
    
  </body>
</html>
