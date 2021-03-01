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
        <h3>{{ $plantel->razon }} {{$datos['fecha_f']}} al {{$datos['fecha_t']}}</h3>
        @php
            $especialidad="";
            $cantidad=0;
            $suma=0;
            $csc=0;
        @endphp
        @foreach ($registros as $registro)
          @if($especialidad<>$registro->especialidad)
          <table class="table table-condensed table-striped">
            <h4>{{ $registro->especialidad }}</h4>
            <thead>
                <th>No.</th><th>Concepto</th><th>Matricula</th><th>Id</th><th>Alumno</th><th>Grado</th><th>Adeudo</th>
            </thead>
            <tbody>    
          @endif
          <tr>
            <td>{{ $csc++ }}</td><td>{{ $registro->concepto }}</td><td>{{ $registro->matricula }}</td><td>{{ $registro->id }}</td>
            <td>{{ $registro->ape_paterno }} {{ $registro->ape_materno }} {{ $registro->nombre }} {{ $registro->nombre2 }}</td>
            <td>{{ $registro->periodo_estudio }}</td><td>{{ $registro->monto }}</td>
          </tr>
        @php
            $especialidad=$registro->especialidad;
            $cantidad=$cantidad+1;
            $suma=$registro->monto;
        @endphp
        @endforeach
        
            </tbody>
        </table>
    </div>
    
  </body>
</html>
