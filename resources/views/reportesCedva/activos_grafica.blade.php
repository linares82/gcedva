<html>

<head>

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
    body {
      font-family: Verdana;
    }
  </style>

  <!-- optional: mobile support with jqueryui-touch-punch -->
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
  <link href="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.min.css')}}" rel="stylesheet" />

</head>

<body>
  <script type="text/javascript">
    // This example uses a function to provide the input values to pivot()
    google.load("visualization", "1", {
      packages: ["corechart", "charteditor"]
    });
    $(function() {
      var renderers = $.extend($.pivotUtilities.renderers,
        $.pivotUtilities.gchart_renderers);

      var rawData = <?php

                    echo ($registros);

                    ?>;
      var inputFunction = function(callback) {
        rawData.forEach(function(element, index) {
          callback({
            Plantel: element.razon,
            Seccion: element.seccion,
            IdCliente: element.cliente,
            Matricula: element.matricula,
            Concepto: element.concepto,
            StClienteId: element.estatus_cliente_id,
            StCliente: element.estatus_cliente,
            Pagado: element.pagado_bnd,
            Anio: element.anio_planeado
          });
        });
      };

      /*$("#output").pivot(inputFunction, {
          rows: ["Plantel","Empleado"], 
          cols: ['Especialidad','Meta', 'Nivel', 'Grado'],
      });*/
      $("#output").pivotUI(inputFunction, {
        renderers: renderers,
        rows: ["Plantel"],
        cols: ['Anio', 'Concepto']
      }, false, "es");

    });
  </script>

  <div id="output" style="margin: 30px;"></div>
  <!--
  <div class="datagrid">

    <table class="table table-condensed table-striped">
      <h4>Activos</h4>
      <thead>
        <th>No.</th>
        <th>Plantel</th>
        <th>Ciclo</th>
        <th>Id</th>
        <th>Matricula</th>
        <th>Seccion</th>
        <th>A. Paterno</th>
        <th>A. Materno</th>
        <th>Nombre(s)</th>
        <th>Estatus C.</th>
        <th>Estatus S.</th>
        <th>Turno</th>
        <th>F. Planeada</th>
        <th>Monto Planeado</th>
        <th>Concepto</th>
        <th>Ticket</th>
        <th>F. Caja</th>
        <th>Total Caja</th>
        <th>Usuario Pago</th>
        <th>Pagado</th>
        <th>Total Adeudo</th>
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
                  <td>Totales Concepto</td>
                  <td colspan='12'>
                  </td>
                  <td>{{ number_format($planeado_suma,2) }}</td>
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
                    <td>Totales Ciclo</td>
                    <td colspan='12'>
                    </td>
                    <td>{{ number_format($ciclo_planeado_suma,2) }}</td>
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
                      <td>Totales Plantel</td>
                      <td colspan='12'>
                      </td>
                      <td>{{ number_format($plantel_planeado_suma,2) }}</td>
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
                      <td>{{ ++$csc }}</td>
                      <td>{{ $registro->razon }}</td>
                      <td>{{ $registro->ciclo }}</td>
                      <td>{{ $registro->cliente }}</td>
                      <td>{{ $registro->matricula }}</td>
                      <td>{{ $registro->seccion }}</td>
                      <td>{{ $registro->ape_paterno }} </td>
                      <td>{{ $registro->ape_materno }}</td>
                      <td>{{ $registro->nombre }} {{ $registro->nombre2 }}</td>
                      <td>{{ $registro->estatus_cliente }}</td>
                      <td>{{ $registro->estatus_seguimiento }}</td>
                      <td>{{ $registro->turno }}</td>
                      <td>{{ $registro->fecha_pago }}</td>
                      <td>{{ number_format($registro->monto,2) }}</td>
                      <td>{{ $registro->concepto }}</td>
                      <td>{{ $registro->consecutivo }}</td>
                      <td>{{ $registro->fecha_caja==0 ? "" :$registro->fecha_caja }}</td>
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
                        {{ number_format($registro['monto'],2) }}
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
                    <tr>
                      <td>Totales Concepto</td>
                      <td colspan='12'>
                      </td>
                      <td>{{ number_format($planeado_suma,2) }}</td>
                      <td colspan='3'></td>
                      <td>{{ number_format($caja_suma,2) }}</td>
                      <td></td>
                      <td>{{ number_format($adeudo_suma,2) }}</td>
                    </tr>
                    <tr>
                      <td>Totales Ciclo</td>
                      <td colspan='12'>
                      </td>
                      <td>{{ number_format($ciclo_planeado_suma,2) }}</td>
                      <td colspan='3'></td>
                      <td>{{ number_format($ciclo_caja_suma,2) }}</td>
                      <td></td>
                      <td>{{ number_format($ciclo_adeudo_suma,2) }}</td>
                    </tr>
                    <tr>
                      <td>Totales Plantel</td>
                      <td colspan='12'>
                      </td>
                      <td>{{ number_format($plantel_planeado_suma,2) }}</td>
                      <td colspan='3'></td>
                      <td>{{ number_format($plantel_caja_suma,2) }}</td>
                      <td></td>
                      <td>{{ number_format($plantel_adeudo_suma,2) }}</td>
                    </tr>

      </tbody>
    </table>
  </div>
                  -->

</body>

</html>