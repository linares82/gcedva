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
            <h4>Activos</h4>
            <thead>
                <th>No.</th><th>Plantel</th><th>Id</th><th>Matricula</th><th>Seccion</th>
                <th>A. Paterno</th><th>A. Materno</th><th>A. Materno</th><th>Estatus C.</th>
                <th>Estatus S.</th>
                <th>F. Planeada</th><th>Monto Planeado</th><th>Concepto</th><th>Ticket</th>
                <th>F. Caja</th><th>Total Caja</th><th>Pagado</th><th>Total Adeudo</th>
            </thead>
            <tbody>    
        @php
        $cantidad=0;
        $suma_planeada=0;
        $suma_adeudos=0;
        $suma_caja=0;
        $csc=0;
        $matricula="";
        @endphp
        @foreach ($registros as $registro)
          <tr>
            <td>{{ ++$csc }}</td><td>{{ $registro->razon }}</td><td>{{ $registro->cliente }}</td><td>{{ $registro->matricula }}</td><td>{{ $registro->seccion }}</td>
            <td>{{ $registro->ape_paterno }} </td><td>{{ $registro->ape_materno }}</td><td>{{ $registro->nombre }} {{ $registro->nombre2 }}</td>
            <td>{{ $registro->estatus_cliente }}</td><td>{{ $registro->estatus_seguimiento }}</td>
            <td>{{ $registro->fecha_pago }}</td><td>{{ number_format($registro->monto,2) }}</td>
            <td>{{ $registro->concepto }}</td><td>{{ $registro->consecutivo }}</td><td>{{ $registro->fecha_caja }}</td>
            <td>{{ number_format($registro->total_caja,2) }}</td><td>@if($registro->pagado_bnd==1) Si @else No @endif</td>
            <td>
              @if($registro->pagado_bnd==0)
              {{ number_format($registro->monto,2) }}
              @else
                0
              @endif
            </td>
          </tr>
        @php
            //$especialidad=$registro->especialidad;
            $cantidad=$cantidad+1;
            $suma_planeada=$suma_planeada+$registro->monto;
            $suma_caja=$suma_caja+$registro->total_caja;
            if($registro->pagado_bnd==0){
              $suma_adeudos=$suma_adeudos+$registro->monto;
            }
        @endphp
        @endforeach
        <tr><td>Totales</td><td colspan='10'>
          </td><td>{{ number_format($suma_planeada,2) }}</td>
          <td colspan='3'></td>
          <td>{{ number_format($suma_caja,2) }}</td>
          <td></td>
          <td>{{ number_format($suma_adeudos,2) }}</td>
        </tr>
            </tbody>
        </table>
    </div>
    
  </body>
</html>
