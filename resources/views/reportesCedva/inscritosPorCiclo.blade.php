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
        
        
        <table class="table table-condensed table-striped">
            <h4>Inscritos Por Ciclo</h4>
            <thead>
                <th>No.</th><th>Plantel</th><th>Id</th><th>Matricula</th><th>Seccion</th>
                <th>A. Paterno</th><th>A. Materno</th>
                <th>A. Materno</th><th>Estatus</th><th>Concepto Pagado</th><th>Ciclo/Periodo Lectivo</th>
            </thead>
            <tbody>    
        @php
        $cantidad=0;
        $suma=0;
        $csc=0;
        $matricula="";
        $plantel="";
        $suma_plantel=0;
        $ciclo="";
        $suma_ciclo=0;
        @endphp
        @foreach ($registros as $registro)
          @if($plantel<>"" and $plantel<>$registro->razon)
          <tr><td>Suma Plantel</td><td>{{ $suma_plantel }}</td></tr>
          @php
              $suma_plantel=0;
          @endphp
          <tr>   
          @endif
          @if($ciclo<>"" and $ciclo<>$registro->ciclo_matricula)
          <tr><td>Suma Concepto</td><td>{{ $suma_ciclo }}</td></tr>
          @php
              $suma_ciclo=0;
          @endphp
          <tr>   
          @endif  
          <tr>
            <td>{{ ++$csc }}</td><td>{{ $registro->razon }}</td><td>{{ $registro->cliente }}</td><td>{{ $registro->matricula }}</td><td>{{ $registro->seccion }}</td>
            <td>{{ $registro->ape_paterno }} </td><td>{{ $registro->ape_materno }}</td><td>{{ $registro->nombre }} {{ $registro->nombre2 }}</td>
            <td>{{ $registro->estatus }}</td><td>{{ $registro->concepto }}</td><td>{{ $registro->ciclo_matricula }}</td>
          </tr>
        @php
            //$especialidad=$registro->especialidad;
            $cantidad=$cantidad+1;
            $suma=$registro->monto;
            $plantel=$registro->razon;
            $suma_plantel=$suma_plantel+1;
            $ciclo=$registro->ciclo_matricula;
            $suma_ciclo=$suma_ciclo+1;
        @endphp
        @endforeach
        <tr><td>Total Activos</td><td>{{ $cantidad }}</td></tr>
            </tbody>
        </table>
    </div>
    
  </body>
</html>
