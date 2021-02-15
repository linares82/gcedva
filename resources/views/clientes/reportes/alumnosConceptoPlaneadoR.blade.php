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
            <th>Plantel</th><th>Id</th><th>Matricula</th><th>P. Nombre</th><th>S. Nombre</th><th>A. Paterno</th><th>A. Materno</th>
            <th>F. Nacimiento</th><th>Especialidad</th>
            <th>Estatus Cliente</th><th>Estatus Seguimiento</th><th>Concepto</th>
        </thead>
        <tbody>    
          @php
              $csc=0;
          @endphp
        @foreach ($registros as $registro)
          
          
          <tr>
            <td>{{ ++$csc }}</td>
            <td>{{ $registro->razon }}</td><td>{{ $registro->id }}</td><td>{{ $registro->matricula }}</td>
            <td>{{ $registro->nombre }}</td><td>{{ $registro->nombre2 }}</td>
            <td>{{ $registro->ape_paterno }}</td><td> {{ $registro->ape_materno }}  </td>
            <td>{{ $registro->fec_nacimiento }}</td><td>{{ $registro->especialidad }}</td>
            <td>{{ $registro->estatus_cliente }}</td><td>{{ $registro->estatus_seguimiento }}</td><td>{{ $registro->concepto }}</td>
          </tr>
        
        @endforeach
        
            </tbody>
        </table>
    </div>
    
  </body>
</html>
