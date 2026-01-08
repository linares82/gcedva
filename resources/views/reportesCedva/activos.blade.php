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
            <h4>Resumen Pagados y No Pagados</h4>
            <thead>
              <th>Plantel</th><th>Seccion</th>
              <th>Nueva Inscripcion</th>
              <th>Activos Vigentes Sin Adeudo</th>
              <th>Activos Vigentes Con 1 Adeudo</th><th>BTP</th><th>BA</th>
              <th>Preinscritos</th>
              <th>Suma (Matricula Total Activa)</th>
              <th>Bajas</th>
              <th>Bajas Automaticas Definitivas</th>
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
              $t7=0;
              $t8=0;
              @endphp
              @foreach($resumen as $linea)
              <!--<tr>
                <td>{{$linea['razon']}}</td><td>{{$linea['seccion']}}</td>
                <td>{{ $linea['nueva_inscripcion']}}</td>
                <td>{{ $linea['vigentes_sin_adeudos']}}</td>
                <td>{{$linea['vigentes_con_1_adeudos']}}</td><td>{{$linea['baja_temporal_por_pago']}}</td><td>{{$linea['baja_administrativa']}}</td>
                <td>{{$linea['preinscrito']}}</td>
                <td>{{$linea['matricula_total_activa']}}</td>
              </tr>-->
              @php
              $t0=$t0+$linea['nueva_inscripcion'];
              $t1=$t1+$linea['vigentes_sin_adeudos'];
              $t2=$t2+$linea['vigentes_con_1_adeudos'];
              $t3=$t3+$linea['baja_temporal_por_pago'];
              $t4=$t4+$linea['baja_administrativa'];
              $t5=$t5+$linea['preinscrito'];
              $t6=$t6+$linea['matricula_total_activa'];
              $t7=$t7+$linea['bajas'];
              $t8=$t8+$linea['baja_automaticas'];
              @endphp
              @endforeach
              <tr><td>Totales</td><td></td>
                  <td>{{$t0}}</td>
                  <td>{{$t1}}</td><td>{{$t2}}</td><td>{{$t3}}</td>
                  <td>{{$t4}}</td><td>{{$t5}}</td><td>{{$t6}}</td>
                  <td>{{$t7}}</td><td>{{$t8}}</td>
              </tr>
            </tbody>
    </table>    

    @if($datos['pagos_f']==0 or $datos['pagos_f']==1)
    <table class="table table-condensed table-striped">
            <h4>Resumen Pagados</h4>
            <thead>
              <th>Plantel</th><th>Seccion</th>
              <th>Nueva Inscripcion</th>
              <th>Activos Vigentes Sin Adeudo</th>
              <th>Activos Vigentes Con 1 Adeudo</th><th>BTP</th><th>BA</th>
              <th>Preinscritos</th><th>Suma (Matricula Total Activa)</th>
              <th>Bajas</th><th>Bajas Automaticas Definitivas</th>
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
              $t7=0;
              $t8=0;
              @endphp
              @foreach($resumen as $linea)
              <tr>
                <td>{{$linea['razon']}}</td><td>{{$linea['seccion']}}</td>
                <td>{{ $linea['nueva_inscripcion_pagados']}}</td>
                <td>{{ $linea['vigentes_sin_adeudos_pagados']}}</td>
                <td>{{$linea['vigentes_con_1_adeudos_pagados']}}</td><td>{{$linea['baja_temporal_por_pago_pagados']}}</td><td>{{$linea['baja_administrativa_pagados']}}</td>
                <td>{{$linea['preinscrito_pagados']}}</td>
                <td>{{$linea['matricula_total_activa_pagados']}}</td>
                <td>{{$linea['bajas_pagados']}}</td>
                <td>{{$linea['baja_automaticas_pagados']}}</td>
              </tr>
              @php
              $t0=$t0+$linea['nueva_inscripcion_pagados'];
              $t1=$t1+$linea['vigentes_sin_adeudos_pagados'];
              $t2=$t2+$linea['vigentes_con_1_adeudos_pagados'];
              $t3=$t3+$linea['baja_temporal_por_pago_pagados'];
              $t4=$t4+$linea['baja_administrativa_pagados'];
              $t5=$t5+$linea['preinscrito_pagados'];
              $t6=$t6+$linea['matricula_total_activa_pagados'];
              $t7=$t7+$linea['bajas_pagados'];
              $t8=$t8+$linea['baja_automaticas_pagados'];
              @endphp
              @endforeach
              <tr><td>Totales</td><td></td>
                  <td>{{$t0}}</td>
                  <td>{{$t1}}</td><td>{{$t2}}</td><td>{{$t3}}</td>
                  <td>{{$t4}}</td><td>{{$t5}}</td><td>{{$t6}}</td>
                  <td>{{$t7}}</td><td>{{$t8}}</td>
              </tr>
            </tbody>
    </table>
    @endif
    @if($datos['pagos_f']==0 or $datos['pagos_f']==2)
    <table class="table table-condensed table-striped">
            <h4>Resumen No Pagados</h4>
            <thead>
              <th>Plantel</th><th>Seccion</th>
              <th>Nueva Inscripcion</th>
              <th>Activos Vigentes Sin Adeudo</th>
              <th>Activos Vigentes Con 1 Adeudo</th><th>BTP</th><th>BA</th>
              <th>Preinscritos</th><th>Suma (Matricula Total Activa)</th>
              <th>Bajas</th><th>Bajas Automaticas Definitivas</th>
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
              $t7=0;
              $t8=0;
              @endphp
              @foreach($resumen as $linea)
              <tr>
                <td>{{$linea['razon']}}</td><td>{{$linea['seccion']}}</td>
                <td>{{ $linea['nueva_inscripcion_no_pagados']}}</td>
                <td>{{ $linea['vigentes_sin_adeudos_no_pagados']}}</td>
                <td>{{$linea['vigentes_con_1_adeudos_no_pagados']}}</td><td>{{$linea['baja_temporal_por_pago_no_pagados']}}</td><td>{{$linea['baja_administrativa_no_pagados']}}</td>
                <td>{{$linea['preinscrito_no_pagados']}}</td>
                <td>{{$linea['matricula_total_activa_no_pagados']}}</td>
                <td>{{$linea['bajas_no_pagados']}}</td>
                <td>{{$linea['baja_automaticas_no_pagados']}}</td>
              </tr>
              @php
              $t0=$t0+$linea['nueva_inscripcion_no_pagados'];
              $t1=$t1+$linea['vigentes_sin_adeudos_no_pagados'];
              $t2=$t2+$linea['vigentes_con_1_adeudos_no_pagados'];
              $t3=$t3+$linea['baja_temporal_por_pago_no_pagados'];
              $t4=$t4+$linea['baja_administrativa_no_pagados'];
              $t5=$t5+$linea['preinscrito_no_pagados'];
              $t6=$t6+$linea['matricula_total_activa_no_pagados'];
              $t7=$t7+$linea['bajas_no_pagados'];
              $t8=$t8+$linea['baja_automaticas_no_pagados'];
              @endphp
              @endforeach
              <tr><td>Totales</td><td></td>
                  <td>{{$t0}}</td>
                  <td>{{$t1}}</td><td>{{$t2}}</td><td>{{$t3}}</td>
                  <td>{{$t4}}</td><td>{{$t5}}</td><td>{{$t6}}</td>
                  <td>{{$t7}}</td><td>{{$t8}}</td>
              </tr>
            </tbody>
    </table>
    @endif

    @permission('reportesCedva.activosSinDinero')
<!--
    <table class="table table-condensed table-striped">
            <h4>Resumen Monetario Pagados y No pagados</h4>
            <thead>
              <th>Plantel</th><th>Seccion</th>
              <th>Nueva Inscripcion</th>
              <th>Activos Vigentes Sin Adeudo</th>
              <th>Activos Vigentes Con 1 Adeudo</th><th>BTP</th><th>BA</th>
              <th>Preinscritos</th>
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
              $t7=0;
              $t8=0;
              @endphp
              @foreach($resumen_dinero as $linea)
              <tr>
                <td>{{$linea['razon']}}</td><td>{{$linea['seccion']}}</td>
                <td align="right">{{number_format($linea['nueva_inscripcion'],2)}}</td>
                <td align="right">{{number_format($linea['vigentes_sin_adeudos'],2)}}</td>
                <td align="right">{{number_format($linea['vigentes_con_1_adeudos'],2)}}</td>
                <td align="right">{{number_format($linea['baja_temporal_por_pago'],2)}}</td>
                <td align="right">{{number_format($linea['baja_administrativa'],2)}}</td>
                <td align="right">{{number_format($linea['preinscrito'],2)}}</td>
                <td align="right">{{number_format($linea['matricula_total_activa'],2)}}</td>
                
              </tr>
              @php
              $t0=$t0+$linea['nueva_inscripcion'];
              $t1=$t1+$linea['vigentes_sin_adeudos'];
              $t2=$t2+$linea['vigentes_con_1_adeudos'];
              $t3=$t3+$linea['baja_temporal_por_pago'];
              $t4=$t4+$linea['baja_administrativa'];
              $t5=$t5+$linea['preinscrito'];
              $t6=$t6+$linea['matricula_total_activa'];
              $t7=$t7+$linea['bajas'];
              $t8=$t8+$linea['baja_automaticas'];
              @endphp
              @endforeach
              <tr><td>Totales</td><td></td>
              <td align="right">{{number_format($t0,2)}}</td>  
                <td align="right">{{number_format($t1,2)}}</td><td align="right">{{number_format($t2,2)}}</td><td align="right">{{number_format($t3,2)}}</td>
                  <td align="right">{{number_format($t4,2)}}</td><td align="right">{{number_format($t5,2)}}</td><td align="right">{{number_format($t6,2)}}</td>
                  
              </tr>
            </tbody>
    </table> 
-->
    @if($datos['pagos_f']==1)
    <table class="table table-condensed table-striped">
            <h4>Resumen Monetario Pagados</h4>
            <thead>
              <th>Plantel</th><th>Seccion</th>
              <th>Nueva Inscripcion</th>
              <th>Activos Vigentes Sin Adeudo</th>
              <th>Activos Vigentes Con 1 Adeudo</th><th>BTP</th><th>BA</th>
              <th>Preinscritos</th>
              <th>Suma (Matricula Total Activa)</th>
              <th>Bajas</th><th>Bajas Automaticas Definitivas</th>
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
              $t7=0;
              $t8=0;
              @endphp
              @foreach($resumen_dinero as $linea)
              <tr>
                <td>{{$linea['razon']}}</td><td>{{$linea['seccion']}}</td>
                <td align="right">{{number_format($linea['nueva_inscripcion_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['vigentes_sin_adeudos_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['vigentes_con_1_adeudos_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['baja_temporal_por_pago_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['baja_administrativa_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['preinscrito_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['matricula_total_activa_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['bajas_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['baja_automaticas_pagados'],2)}}</td>
              </tr>
              @php
              $t0=$t0+$linea['nueva_inscripcion_pagados'];
              $t1=$t1+$linea['vigentes_sin_adeudos_pagados'];
              $t2=$t2+$linea['vigentes_con_1_adeudos_pagados'];
              $t3=$t3+$linea['baja_temporal_por_pago_pagados'];
              $t4=$t4+$linea['baja_administrativa_pagados'];
              $t5=$t5+$linea['preinscrito_pagados'];
              $t6=$t6+$linea['matricula_total_activa_pagados'];
              $t7=$t7+$linea['bajas_pagados'];
              $t8=$t8+$linea['baja_automaticas_pagados'];
              @endphp
              @endforeach
              <tr><td>Totales</td><td></td>
              <td align="right">{{number_format($t0,2)}}</td>  
                <td align="right">{{number_format($t1,2)}}</td><td align="right">{{number_format($t2,2)}}</td><td align="right">{{number_format($t3,2)}}</td>
                  <td align="right">{{number_format($t4,2)}}</td><td align="right">{{number_format($t5,2)}}</td><td align="right">{{number_format($t6,2)}}</td>
                  <td align="right">{{number_format($t7,2)}}</td>
                  <td align="right">{{number_format($t8,2)}}</td>
              </tr>
            </tbody>
    </table>
    @endif

    @if($datos['pagos_f']==0 or $datos['pagos_f']==2)
    <table class="table table-condensed table-striped">
            <h4>Resumen Monetario No pagados</h4>
            <thead>
              <th>Plantel</th><th>Seccion</th>
              <th>Nueva Inscripcion</th>
              <th>Activos Vigentes Sin Adeudo</th>
              <th>Activos Vigentes Con 1 Adeudo</th><th>BTP</th><th>BA</th>
              <th>Preinscritos</th>
              <th>Suma (Matricula Total Activa)</th>
              <th>Bajas</th><th>Bajas Automaticas Definitivas</th> 
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
              $t7=0;
              $t8=0;
              @endphp
              @foreach($resumen_dinero as $linea)
              <tr>
                <td>{{$linea['razon']}}</td><td>{{$linea['seccion']}}</td>
                <td align="right">{{number_format($linea['nueva_inscripcion_no_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['vigentes_sin_adeudos_no_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['vigentes_con_1_adeudos_no_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['baja_temporal_por_pago_no_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['baja_administrativa_no_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['preinscrito_no_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['matricula_total_activa_no_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['bajas_no_pagados'],2)}}</td>
                <td align="right">{{number_format($linea['baja_automaticas_no_pagados'],2)}}</td>
              </tr>
              @php
              $t0=$t0+$linea['nueva_inscripcion_no_pagados'];
              $t1=$t1+$linea['vigentes_sin_adeudos_no_pagados'];
              $t2=$t2+$linea['vigentes_con_1_adeudos_no_pagados'];
              $t3=$t3+$linea['baja_temporal_por_pago_no_pagados'];
              $t4=$t4+$linea['baja_administrativa_no_pagados'];
              $t5=$t5+$linea['preinscrito_no_pagados'];
              $t6=$t6+$linea['matricula_total_activa_no_pagados'];
              $t7=$t7+$linea['bajas_no_pagados'];
              $t8=$t8+$linea['baja_automaticas_no_pagados'];
              @endphp
              @endforeach
              <tr><td>Totales</td><td></td>
              <td align="right">{{number_format($t0,2)}}</td>  
                <td align="right">{{number_format($t1,2)}}</td><td align="right">{{number_format($t2,2)}}</td><td align="right">{{number_format($t3,2)}}</td>
                  <td align="right">{{number_format($t4,2)}}</td><td align="right">{{number_format($t5,2)}}</td><td align="right">{{number_format($t6,2)}}</td>
              <td align="right">{{number_format($t7,2)}}</td><td align="right">{{number_format($t8,2)}}</td>      
              </tr>
            </tbody>
    </table>
    @endif

    @endif
    <!--
        <h1>detalle anterior</h1>
        <table class="table table-condensed table-striped">
            <h4>Activos</h4>
            <thead>
                <th>No.</th><th>Plantel</th><th>Ciclo</th><th>Id</th><th>Matricula</th><th>Seccion</th>
                <th>A. Paterno</th><th>A. Materno</th><th>Nombre(s)</th><th>Tel. Fijo</th><th>Celular</th><th>Estatus C.</th>
                <th>Estatus S.</th><th>Turno</th>
                <th>F. Planeada</th>
                @permission('reportesCedva.activosSinDinero')<th>Monto Planeado</th>@endpermission
                <th>Concepto</th><th>Ticket</th>
                <th>F. Caja</th>
                @permission('reportesCedva.activosSinDinero')<th>Total Caja</th>@endpermission
                <th>Usuario Pago</th><th>Pagado</th>
                @permission('reportesCedva.activosSinDinero')<th>Total Adeudo</th>@endpermission
                

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
          @permission('reportesCedva.activosSinDinero')
          @if($plantel<>"" and $ciclo<>"" and $concepto<>"")
              @if($concepto<>$registro['concepto'])
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
              @if($ciclo<>$registro['ciclo'])
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
              @if($plantel<>$registro['razon'])
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
          @endpermission
          <tr>
            <td>{{ ++$csc }}</td><td>{{ $registro['razon'] }}</td><td>{{ $registro['ciclo'] }}</td><td>{{ $registro['cliente'] }}</td><td>{{ $registro['matricula'] }}</td><td>{{ $registro['seccion'] }}</td>
            <td>{{ $registro['ape_paterno'] }} </td><td>{{ $registro['ape_materno'] }}</td><td>{{ $registro['nombre'] }} {{ $registro['nombre2'] }}</td>
            <td>{{ $registro['tel_fijo'] }}</td><td>{{ $registro['tel_cel'] }}</td>
            <td>{{ $registro['estatus_cliente'] }}</td><td>{{ $registro['estatus_seguimiento'] }}</td>
            <td>{{ $registro['turno'] }}</td>
            <td>{{ $registro['fecha_pago'] }}</td>
            @permission('reportesCedva.activosSinDinero')<td>{{ number_format($registro['monto'],2) }}</td>@endpermission
            <td>{{ $registro['concepto'] }}</td><td>{{ $registro['consecutivo'] }}</td>
            <td>{{ $registro['fecha_caja']==0 ? "" :$registro['fecha_caja'] }}</td>
            @permission('reportesCedva.activosSinDinero')<td>{{ number_format($registro['total_caja'],2) }}</td>@endpermission
            <td>
              @php
                if(is_int($registro['caja_id']) and $registro['caja_id']<>0){
                  $pago=App\Pago::where('caja_id', $registro['caja_id'])->with('usu_alta')->first();    
                    if(!is_null($pago)){
                    echo $pago->usu_alta->name;
                  }
                }
                
              @endphp
                
            </td>
            <td>@if($registro['pagado_bnd']==1) Si @else No @endif</td>
            @permission('reportesCedva.activosSinDinero')
            <td>
              
              @if($registro['pagado_bnd']==0)
              {{ number_format($registro['monto'],2) }}
              @php
                $adeudo_suma=$adeudo_suma+$registro['monto'];    
                $ciclo_adeudo_suma=$ciclo_adeudo_suma+$registro['monto'];    
                $plantel_adeudo_suma=$plantel_adeudo_suma+$registro['monto'];    
              @endphp

              
              @else
                0
              @endif
              
            </td>
            @endpermission
          </tr>
        @php
            //$especialidad=$registro->especialidad;
            $cantidad=$cantidad+1;
            $suma_planeada=$suma_planeada+$registro['monto'];
            $suma_caja=$suma_caja+$registro['total_caja'];
            if($registro['pagado_bnd']==0){
              $suma_adeudos=$suma_adeudos+$registro['monto'];
            }
            $plantel=$registro['razon'];
            $planeado_suma=$planeado_suma+$registro['monto'];
            $ciclo_planeado_suma=$ciclo_planeado_suma+$registro['monto'];
            $plantel_planeado_suma=$plantel_planeado_suma+$registro['monto'];
            $ciclo=$registro['ciclo'];
            $caja_suma=$caja_suma+$registro['total_caja'];
            $ciclo_caja_suma=$ciclo_caja_suma+$registro['total_caja'];
            $plantel_caja_suma=$plantel_caja_suma+$registro['total_caja'];
            $concepto=$registro['concepto'];
            
            
        @endphp
        @endforeach
        @permission('reportesCedva.activosSinDinero')
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
        @endpermission  
            </tbody>
        </table>
        <h2>ultimo detalle</h2>
          -->
          
        <table class="table table-condensed table-striped">
            <h4>Detalle</h4>
            <thead>
                <th>No.</th><th>Plantel</th><th>Ciclo</th><th>Id</th><th>Matricula</th><th>Seccion</th>
                <th>A. Paterno</th><th>A. Materno</th><th>Nombre(s)</th>
                <th>Genero</th><th>F. Nacimiento</th>
                <th>Tel. Fijo</th><th>Celular</th><th>Estatus C.</th>
                <th>Estatus S.</th><th>Turno</th>
                <th>F. Planeada</th>
                @permission('reportesCedva.activosSinDinero')<th>Monto Planeado</th>@endpermission
                <th>Concepto</th><th>Ticket</th>
                <th>F. Caja</th>
                @permission('reportesCedva.activosSinDinero')
                <th>Total Caja</th>
                <th>Descuentos</th>
                <th>% Promocion</th>
                <th>% Beca</th>
                @endpermission
                <th>Usuario Pago</th><th>Pagado</th>
                @permission('reportesCedva.activosSinDinero')<th>Total Adeudo</th>@endpermission
                

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
        @foreach ($registros_ordenados as $seccion)
          
          @foreach($seccion as $registro)
          <!--
          @permission('reportesCedva.activosSinDinero')
          @if($plantel<>"" and $ciclo<>"" and $concepto<>"")
              @if($concepto<>$registro['concepto'])
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
              @if($ciclo<>$registro['ciclo'])
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
              @if($plantel<>$registro['razon'])
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
          @endpermission
-->
          <tr>
            <td>{{ ++$csc }}</td><td>{{ $registro['razon'] }}</td><td>{{ $registro['ciclo'] }}</td><td>{{ $registro['cliente'] }}</td><td>{{ $registro['matricula'] }}</td><td>{{ $registro['seccion'] }}</td>
            <td>{{ $registro['ape_paterno'] }} </td><td>{{ $registro['ape_materno'] }}</td><td>{{ $registro['nombre'] }} {{ $registro['nombre2'] }}</td>
            <td> 
              @if($registro['genero']==1)
                Hombre
              @elseif(is_null($registro['genero']))
              
              @else
                Mujer
              @endif
            
            </td>
            <td>{{ $registro['fec_nacimiento'] }}</td>
            <td>{{ $registro['tel_fijo'] }}</td><td>{{ $registro['tel_cel'] }}</td>
            <td>{{ $registro['estatus_cliente'] }}</td><td>{{ $registro['estatus_seguimiento'] }}</td>
            <td>{{ $registro['turno'] }}</td>
            <td>{{ $registro['fecha_pago'] }}</td>
            @permission('reportesCedva.activosSinDinero')<td>{{ number_format($registro['monto'],2) }}</td>@endpermission
            <td>{{ $registro['concepto'] }}</td><td>{{ $registro['consecutivo'] }}</td>
            <td>{{ $registro['fecha_caja']==0 ? "" :$registro['fecha_caja'] }}</td>
            @permission('reportesCedva.activosSinDinero')
            <td>{{ number_format($registro['total_caja'],2) }}</td>
            <td>{{ number_format($registro['descuento'],2) }}</td>
            <td>
              
                @php
                  
                  if($registro['adeudo_id']>0 and $registro['consecutivo']>0){
                    $adeudo=\App\Adeudo::find($registro['adeudo_id']);
                    $adeudo->load(['planPagoLn','planPagoLn.promoPlanLns']);
                    foreach($adeudo->planPagoLn->promoPlanLns as $ppp){
                      $inicio= new Datetime($ppp->fec_inicio);
                      $fin= new Datetime($ppp->fec_fin);
                      $fecha_caja= new Datetime($registro['fecha_caja']);
                      if($inicio<=$fecha_caja and $fin>=$fecha_caja){
                        echo $ppp->descuento;
                      }else{
                        echo "0";
                      }
                    }
                  }elseif($registro['adeudo_id']>0 and $registro['consecutivo']==0){
                    $adeudo=\App\Adeudo::find($registro['adeudo_id']);
                    $adeudo->load(['planPagoLn','planPagoLn.promoPlanLns']);
                    foreach($adeudo->planPagoLn->promoPlanLns as $ppp){
                      $inicio= new Datetime($ppp->fec_inicio);
                      $fin= new Datetime($ppp->fec_fin);
                      $fecha_caja= new Datetime(date('Y-m-d'));
                      if($inicio<=$fecha_caja and $fin>=$fecha_caja){
                        echo $ppp->descuento;
                      }else{
                        echo "0";
                      }
                    }
                  }else{
                    echo "0";
                  }
                @endphp
              
            </td>
            <td>
              @php
                $becas=App\AutorizacionBeca::where('cliente_id', $registro['cliente'])->get();
                
                $fecha_caja_hoy= new Datetime(date('Y-m-d'));
                $fecha_caja= new Datetime($registro['fecha_pago']);
                
                if(count($becas)>0){
                  foreach($becas as $beca){
                    $inicio= new Datetime($beca->lectivo->inicio);
                    $fin= new Datetime($beca->lectivo->fin);

                    if($inicio<$fecha_caja_hoy and 
                       $fin>$fecha_caja_hoy and 
                       $registro['pagado_bnd']<>1 and 
                       $registro['bnd_mensualidad']==1 and 
                       ($registro['bnd_eximir_descuento_beca']==0 or is_null($registro['bnd_eximir_descuento_beca']))){
                        //echo $beca->monto_mensualidad*$registro['monto'];
                        echo $beca->monto_mensualidad;
                    }elseif($inicio<$fecha_caja and 
                       $fin>$fecha_caja and 
                       $registro['pagado_bnd']==1 and 
                       $registro['bnd_mensualidad']==1 and 
                       ($registro['bnd_eximir_descuento_beca']==0 or is_null($registro['bnd_eximir_descuento_beca']))){
                        //echo $beca->monto_mensualidad*$registro['monto'];
                        echo $beca->monto_mensualidad;
                    }else{
                      echo "0";
                    }
                  }
                }else{
                  echo "0";
                }
              @endphp
            </td>
            @endpermission
            <td>
              @php
                if(is_int($registro['caja_id']) and $registro['caja_id']<>0){
                  $pago=App\Pago::where('caja_id', $registro['caja_id'])->with('usu_alta')->first();    
                  if(!is_null($pago)){
                    echo $pago->usu_alta->name;
                  }
                }
                
              @endphp
                
            </td>
            <td>@if($registro['pagado_bnd']==1) Si @else No @endif</td>
            @permission('reportesCedva.activosSinDinero')
            <td>
              
              @if($registro['pagado_bnd']==0)
              {{ number_format($registro['monto'],2) }}
              @php
                $adeudo_suma=$adeudo_suma+$registro['monto'];    
                $ciclo_adeudo_suma=$ciclo_adeudo_suma+$registro['monto'];    
                $plantel_adeudo_suma=$plantel_adeudo_suma+$registro['monto'];    
              @endphp

              
              @else
                0
              @endif
              
            </td>
            @endpermission
          </tr>
        @php
            //$especialidad=$registro->especialidad;
            $cantidad=$cantidad+1;
            $suma_planeada=$suma_planeada+$registro['monto'];
            $suma_caja=$suma_caja+$registro['total_caja'];
            if($registro['pagado_bnd']==0){
              $suma_adeudos=$suma_adeudos+$registro['monto'];
            }
            $plantel=$registro['razon'];
            $planeado_suma=$planeado_suma+$registro['monto'];
            $ciclo_planeado_suma=$ciclo_planeado_suma+$registro['monto'];
            $plantel_planeado_suma=$plantel_planeado_suma+$registro['monto'];
            $ciclo=$registro['ciclo'];
            $caja_suma=$caja_suma+$registro['total_caja'];
            $ciclo_caja_suma=$ciclo_caja_suma+$registro['total_caja'];
            $plantel_caja_suma=$plantel_caja_suma+$registro['total_caja'];
            $concepto=$registro['concepto'];
            
            
        @endphp
        @endforeach
        @endforeach
        <!--
        @permission('reportesCedva.activosSinDinero')
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
        @endpermission  
          -->
            </tbody>
        </table>
    </div>
    
  </body>
</html>
