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
        <h3>Concretados</h3>
        <table class="table table-condensed table-striped">
          
          <thead>
              <th>Plantel</th><th>Concretados</th>
          </thead>
          <tbody>    
            @foreach ($totales as $total)
            <tr>
              <td>{{ $total->razon }}</td><td>{{ $total->total_matriculas }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <!--
        <h3>Detalle</h3>
        <table class="table table-condensed table-striped">
          
          <thead>
            <th>No.</th>
              <th>Plantel</th><th>Matricula</th><th>Estatus</th><th>Fecha Caja</th><th>Concepto</th>
          </thead>
          <tbody>    
            @foreach ($detalle as $ln)
            <tr>
              <td>{{ ++$id }}</td>
              <td>{{ $ln->razon }}</td><td>{{ $ln->matricula }}</td><td>{{ $ln->st_cliente }}</td>
              <td>{{ $ln->fecha_caja }}</td><td>{{ $ln->concepto }}</td>
            </tr>
            @endforeach
            
            </tbody>
        </table>
      -->
    </div>
    
  </body>
</html>
