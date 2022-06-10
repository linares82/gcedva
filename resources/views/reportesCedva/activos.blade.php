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
                <th>No.</th><th>Plantel</th><th>Ciclo</th><th>Id</th><th>Matricula</th><th>Seccion</th>
                <th>A. Paterno</th><th>A. Materno</th><th>Nombre(s)</th><th>Estatus C.</th>
                <th>Estatus S.</th>
                <th>F. Planeada</th><th>Monto Planeado</th><th>Concepto</th><th>Ticket</th>
                <th>F. Caja</th><th>Total Caja</th><th>Usuario Pago</th><th>Pagado</th><th>Total Adeudo</th>
            </thead>
            <tbody>    
        @php
        $cantidad=0;
        $suma_planeada=0;
        $suma_adeudos=0;
        $suma_caja=0;
        $csc=0;
        $matricula="";

        $plantel="";
        $ciclo="";
        $concepto="";
        $planeado_suma=0;
        $caja_suma=0;
        $adeudo_suma=0;
        $ciclo_planeado_suma=0;
        $ciclo_caja_suma=0;
        $ciclo_adeudo_suma=0;
        $plantel_planeado_suma=0;
        $plantel_caja_suma=0;
        $plantel_adeudo_suma=0;
        @endphp
        @foreach ($registros as $registro)
          
          @if($plantel<>"" and $ciclo<>"" and $concepto<>"")
              @if($concepto<>$registro[0]['concepto'])
              <tr>
                <td>Totales Concepto</td><td colspan='11'>
                </td><td>{{ number_format($planeado_suma,2) }}</td>
                <td colspan='3'></td>
                <td>{{ number_format($caja_suma,2) }}</td>
                <td></td>
                <td>{{ number_format($adeudo_suma,2) }}</td>
              </tr>
              @php
                  $planeado_suma=0;
                  $caja_suma=0;
                  $adeudo_suma=0;
              @endphp
              @endif
              @if($ciclo<>$registro[0]['ciclo'])
              <tr>
                <td>Totales Ciclo</td><td colspan='11'>
                </td><td>{{ number_format($ciclo_planeado_suma,2) }}</td>
                <td colspan='3'></td>
                <td>{{ number_format($ciclo_caja_suma,2) }}</td>
                <td></td>
                <td>{{ number_format($ciclo_adeudo_suma,2) }}</td>
              </tr>
              @php
                  $ciclo_planeado_suma=0;
                  $ciclo_caja_suma=0;
                  $ciclo_adeudo_suma=0;
              @endphp
              @endif
              @if($plantel<>$registro[0]['razon'])
              <tr>
                <td>Totales Plantel</td><td colspan='11'>
                </td><td>{{ number_format($plantel_planeado_suma,2) }}</td>
                <td colspan='3'></td>
                <td>{{ number_format($plantel_caja_suma,2) }}</td>
                <td></td>
                <td>{{ number_format($plantel_adeudo_suma,2) }}</td>
              </tr>
              @php
                  $plantel_planeado_suma=0;
                  $plantel_caja_suma=0;
                  $plantel_adeudo_suma=0;
                  
              @endphp
              @endif
              
          @endif
          <tr>
            <td>{{ ++$csc }}</td><td>{{ $registro[0]['razon'] }}</td><td>{{ $registro[0]['ciclo'] }}</td><td>{{ $registro[0]['cliente'] }}</td><td>{{ $registro[0]['matricula'] }}</td><td>{{ $registro[0]['seccion'] }}</td>
            <td>{{ $registro[0]['ape_paterno'] }} </td><td>{{ $registro[0]['ape_materno'] }}</td><td>{{ $registro[0]['nombre'] }} {{ $registro[0]['nombre2'] }}</td>
            <td>{{ $registro[0]['estatus_cliente'] }}</td><td>{{ $registro[0]['estatus_seguimiento'] }}</td>
            <td>{{ $registro[0]['fecha_pago'] }}</td><td>{{ number_format($registro[0]['monto'],2) }}</td>
            <td>{{ $registro[0]['concepto'] }}</td><td>{{ $registro[0]['consecutivo'] }}</td><td>{{ $registro[0]['fecha_caja']==0 ? "" :$registro[0]['fecha_caja'] }}</td>
            <td>{{ number_format($registro[0]['total_caja'],2) }}</td>
            <td>
              @php
                if(is_int($registro[0]['caja_id'])){
                  $pago=App\Pago::where('caja_id', $registro[0]['caja_id'])->first();    
                }
                if(!is_null($pago)){
                  echo $pago->usu_alta->name;
                }
              @endphp
                
            </td>
            <td>@if($registro[0]['pagado_bnd']==1) Si @else No @endif</td>
            <td>
              @if($registro[0]['pagado_bnd']==0)
              {{ number_format($registro[0]['monto'],2) }}
              @php
                $adeudo_suma=$adeudo_suma+$registro[0]['monto'];    
                $ciclo_adeudo_suma=$ciclo_adeudo_suma+$registro[0]['monto'];    
                $plantel_adeudo_suma=$plantel_adeudo_suma+$registro[0]['monto'];    
              @endphp

              
              @else
                0
              @endif
            </td>
          </tr>
        @php
            //$especialidad=$registro->especialidad;
            $cantidad=$cantidad+1;
            $suma_planeada=$suma_planeada+$registro[0]['monto'];
            $suma_caja=$suma_caja+$registro[0]['total_caja'];
            if($registro[0]['pagado_bnd']==0){
              $suma_adeudos=$suma_adeudos+$registro[0]['monto'];
            }
            $plantel=$registro[0]['razon'];
            $planeado_suma=$planeado_suma+$registro[0]['monto'];
            $ciclo_planeado_suma=$ciclo_planeado_suma+$registro[0]['monto'];
            $plantel_planeado_suma=$plantel_planeado_suma+$registro[0]['monto'];
            $ciclo=$registro[0]['ciclo'];
            $caja_suma=$caja_suma+$registro[0]['total_caja'];
            $ciclo_caja_suma=$ciclo_caja_suma+$registro[0]['total_caja'];
            $plantel_caja_suma=$plantel_caja_suma+$registro[0]['total_caja'];
            $concepto=$registro[0]['concepto'];
            
            
        @endphp
        @endforeach
        <tr><td>Totales Concepto</td><td colspan='11'>
          </td><td>{{ number_format($planeado_suma,2) }}</td>
          <td colspan='3'></td>
          <td>{{ number_format($caja_suma,2) }}</td>
          <td></td>
          <td>{{ number_format($adeudo_suma,2) }}</td>
        </tr>
        <tr><td>Totales Ciclo</td><td colspan='11'>
          </td><td>{{ number_format($ciclo_planeado_suma,2) }}</td>
          <td colspan='3'></td>
          <td>{{ number_format($ciclo_caja_suma,2) }}</td>
          <td></td>
          <td>{{ number_format($ciclo_adeudo_suma,2) }}</td>
        </tr>
        <tr><td>Totales Plantel</td><td colspan='11'>
          </td><td>{{ number_format($plantel_planeado_suma,2) }}</td>
          <td colspan='3'></td>
          <td>{{ number_format($plantel_caja_suma,2) }}</td>
          <td></td>
          <td>{{ number_format($plantel_adeudo_suma,2) }}</td>
        </tr>
          
            </tbody>
        </table>
    </div>
    
  </body>
</html>
