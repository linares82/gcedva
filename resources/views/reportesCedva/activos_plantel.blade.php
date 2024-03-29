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
      <script type="text/javascript" src="https://www.google.com/jsapi"></script>

<!-- external libs from cdnjs -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<!-- PivotTable.js libs from ../dist -->
<link rel="stylesheet" type="text/css" href="{{asset('bower_components\AdminLTE\plugins\pivottable-master\dist\pivot.css')}}">
<script type="text/javascript" src="{{asset('bower_components\AdminLTE\plugins\pivottable-master\dist\pivot.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components\AdminLTE\plugins\pivottable-master\dist\pivot.es.js')}}"></script>
<script type="text/javascript" src="{{asset('bower_components\AdminLTE\plugins\pivottable-master\dist\gchart_renderers.js')}}"></script>
<style>
    body {font-family: Verdana;}
</style>

<!-- optional: mobile support with jqueryui-touch-punch -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
<link href="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.min.css')}}" rel="stylesheet" />
    
  </head>
  <body>
    <div class="datagrid">
    <table class="table table-condensed table-striped">
            <h4>Resumen</h4>
            <thead>
              <th>Plantel</th><th>Seccion</th>
              <th>AÃ±o</th><th>Concepto</th>
              <th>Suma (Matricula Total Activa)</th>
            </thead>
            <tbody>
              @php
              $t0=0;
              $t1=0;
              $t2=0;
              $t3=0;
              $t4=0;
              $t5=0;
              $t6=0;
              @endphp
              @foreach($resumen as $linea)
              <tr>
                <td>{{$linea['razon']}}</td><td>{{$linea['seccion']}}</td>
                <td>{{$linea['anio_planeado']}}</td><td>{{$linea['concepto']}}</td>
                <td>{{$linea['total']}}</td>
              </tr>
              @php
              $t0=$t0+$linea['total'];
              $t1=$t1+$linea['vigentes_sin_adeudos'];
              $t2=$t2+$linea['vigentes_con_1_adeudos'];
              $t3=$t3+$linea['baja_temporal_por_pago'];
              $t4=$t4+$linea['baja_administrativa'];
              $t5=$t5+$linea['matricula_total_activa'];
              $t6=$t6+$linea['preinscrito'];
              @endphp
              @endforeach
              <tr><td>Totales</td><td></td><td></td><td></td>
                  <td>{{$t0}}</td></tr>
            </tbody>
    </table>    

    <table class="table table-condensed table-striped">
            @php
              function getRowBy($arreglo, $plantel, $seccion, $anio, $concepto){
                foreach($arreglo as $row){
                  if($row['razon']== $plantel and $row['seccion']==$seccion and
                  $row['anio_planeado']== $anio and $row['concepto']==$concepto){
                    return $row;
                  }
                }
                return array('vigentes_sin_adeudos'=>0, 'vigentes_con_1_adeudos'=>0, 'baja_temporal_por_pago'=>0, 'baja_administrativa'=>0, 'total'=>0);
              }
            @endphp 
            <h4>Resumen</h4>
            <thead>
              <th rowspan="2">Plantel</th><th rowspan="2">Seccion</th>
              @foreach($combinaciones_anio_concepto as $anio_concepto)
                <th>{{$anio_concepto['anio_planeado']}} - {{$anio_concepto['concepto']}}</th>
              @endforeach
              <tr>
              @foreach($combinaciones_anio_concepto as $anio_concepto)
		<th>Matricula Total Activa</th>
              @endforeach
              </tr>
                
            </thead>
            <tbody>
              @foreach($combinaciones_plantel_seccion as $plantel_seccion)
               <tr>
                <td>{{$plantel_seccion['razon']}}</td><td>{{$plantel_seccion['seccion']}}</td>
                @foreach($combinaciones_anio_concepto as $anio_concepto)
                @php
                  $row=getRowBy($resumen, $plantel_seccion['razon'], $plantel_seccion['seccion'], $anio_concepto['anio_planeado'], $anio_concepto['concepto']);
                @endphp

                <td>{{$row['total']}}</td>
                @endforeach
               </tr> 
               @endforeach
            </tbody>
    </table>

    <!--
    <table class="table table-condensed table-striped">
            <h4>Resumen Monetario</h4>
            <thead>
              <th>Plantel</th><th>Seccion</th><th>Activos Vigentes Sin Adeudo</th>
              <th>Activos Vigentes Con 1 Adeudo</th><th>BTP</th><th>BA</th>
              <th>Suma (Matricula Total Activa)</th><th>Preinscritos</th>
            </thead>
            <tbody>
              @php
              $t1=0;
              $t2=0;
              $t3=0;
              $t4=0;
              $t5=0;
              $t6=0;
              @endphp
              @foreach($resumen_dinero as $linea)
              <tr>
                <td>{{$linea['razon']}}</td><td>{{$linea['seccion']}}</td><td align="right">{{number_format($linea['vigentes_sin_adeudos'],2)}}</td>
                <td align="right">{{number_format($linea['vigentes_con_1_adeudos'],2)}}</td><td align="right">{{number_format($linea['baja_temporal_por_pago'],2)}}</td><td align="right">{{number_format($linea['baja_administrativa'],2)}}</td>
                <td align="right">{{number_format($linea['matricula_total_activa'],2)}}</td>
                <td align="right">{{number_format($linea['preinscrito'],2)}}</td>
              </tr>
              @php
              $t1=$t1+$linea['vigentes_sin_adeudos'];
              $t2=$t2+$linea['vigentes_con_1_adeudos'];
              $t3=$t3+$linea['baja_temporal_por_pago'];
              $t4=$t4+$linea['baja_administrativa'];
              $t5=$t5+$linea['matricula_total_activa'];
              $t6=$t6+$linea['preinscrito'];
              @endphp
              @endforeach
              <tr><td>Totales</td><td></td>
                  <td align="right">{{number_format($t1,2)}}</td><td align="right">{{number_format($t2,2)}}</td><td align="right">{{number_format($t3,2)}}</td>
                  <td align="right">{{number_format($t4,2)}}</td><td align="right">{{number_format($t5,2)}}</td><td align="right">{{number_format($t6,2)}}</td>
              </tr>
            </tbody>
    </table>    
-->    
        <table class="table table-condensed table-striped">
            <h4>Activos</h4>
            <thead>
                <th>No.</th><th>Plantel</th><th>Ciclo</th><th>Id</th><th>Matricula</th><th>Seccion</th>
                <th>A. Paterno</th><th>A. Materno</th><th>Nombre(s)</th><th>Estatus C.</th>
                <th>Estatus S.</th><th>Turno</th>
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

        @foreach (json_decode($registros) as $registro)
          
          @if($plantel<>"" and $ciclo<>"" and $concepto<>"")
              @if($concepto<>$registro->concepto)
              <tr>
                <td>Totales Concepto</td><td colspan='12'>
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
              @if($ciclo<>$registro->ciclo)
              <tr>
                <td>Totales Ciclo</td><td colspan='12'>
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
              @if($plantel<>$registro->razon)
              <tr>
                <td>Totales Plantel</td><td colspan='12'>
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
            <td>{{ ++$csc }}</td><td>{{ $registro->razon }}</td><td>{{ $registro->ciclo }}</td><td>{{ $registro->cliente }}</td><td>{{ $registro->matricula }}</td><td>{{ $registro->seccion }}</td>
            <td>{{ $registro->ape_paterno }} </td><td>{{ $registro->ape_materno }}</td><td>{{ $registro->nombre }} {{ $registro->nombre2 }}</td>
            <td>{{ $registro->estatus_cliente }}</td><td>{{ $registro->estatus_seguimiento }}</td>
            <td>{{ $registro->turno }}</td>
            <td>{{ $registro->fecha_pago }}</td><td>{{ number_format($registro->monto,2) }}</td>
            <td>{{ $registro->concepto }}</td><td>{{ $registro->consecutivo }}</td><td>{{ $registro->fecha_caja==0 ? "" :$registro->fecha_caja }}</td>
            <td>{{ number_format($registro->total_caja,2) }}</td>
            <td>
              @php
                if(is_int($registro->caja_id)){
                  $pago=App\Pago::where('caja_id', $registro->caja_id)->first();    
                }
                if(!is_null($pago)){
                  echo $pago->usu_alta->name;
                }
              @endphp
                
            </td>
            <td>@if($registro->pagado_bnd==1) Si @else No @endif</td>
            <td>
              @if($registro->pagado_bnd==0)
              {{ number_format($registro->monto,2) }}
              @php
                $adeudo_suma=$adeudo_suma+$registro->monto;    
                $ciclo_adeudo_suma=$ciclo_adeudo_suma+$registro->monto;    
                $plantel_adeudo_suma=$plantel_adeudo_suma+$registro->monto;    
              @endphp

              
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
            $plantel=$registro->razon;
            $planeado_suma=$planeado_suma+$registro->monto;
            $ciclo_planeado_suma=$ciclo_planeado_suma+$registro->monto;
            $plantel_planeado_suma=$plantel_planeado_suma+$registro->monto;
            $ciclo=$registro->ciclo;
            $caja_suma=$caja_suma+$registro->total_caja;
            $ciclo_caja_suma=$ciclo_caja_suma+$registro->total_caja;
            $plantel_caja_suma=$plantel_caja_suma+$registro->total_caja;
            $concepto=$registro->concepto;
            
            
        @endphp
        @endforeach
        <tr><td>Totales Concepto</td><td colspan='12'>
          </td><td>{{ number_format($planeado_suma,2) }}</td>
          <td colspan='3'></td>
          <td>{{ number_format($caja_suma,2) }}</td>
          <td></td>
          <td>{{ number_format($adeudo_suma,2) }}</td>
        </tr>
        <tr><td>Totales Ciclo</td><td colspan='12'>
          </td><td>{{ number_format($ciclo_planeado_suma,2) }}</td>
          <td colspan='3'></td>
          <td>{{ number_format($ciclo_caja_suma,2) }}</td>
          <td></td>
          <td>{{ number_format($ciclo_adeudo_suma,2) }}</td>
        </tr>
        <tr><td>Totales Plantel</td><td colspan='12'>
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
