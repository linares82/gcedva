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
    <div class="datagrid" style="margin:10px;">
      <h1>Alumnos Activos</h1>
      <table class="table table-condensed table-striped">
        <thead><th>No.</th>
            <th>Plantel</th><th>Alumnos Activo</th><th></th>
        </thead>
        <tbody>    
          @php
              $csc=0;
              $total=0;
          @endphp
        @foreach ($registros as $registro)
          <tr>
            <td>{{ ++$csc }}</td>
            <td>{{ $registro->razon }}</td><td>{{ $registro->alumnos_activos }}</td>
            <td><a href="{{ route('clientes.clientesActivosD', 
            array('razon'=>$registro->razon,'fecha_f'=>$registro->fec_proceso)) }}" target="_blank">Ver</a></td>
          </tr>        
          @php
              $total=$total+$registro->alumnos_activos;
          @endphp
        @endforeach
        <tr>
          <td colspan="2">Total</td><td>{{ $total }}</td>
        </tr>
            </tbody>
        </table>
    </div>
    
  </body>
</html>
