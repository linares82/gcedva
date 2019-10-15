<html>
  <head>
      <link href="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.min.css')}}" rel="stylesheet" />

<style>
    @media print {
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td, .tr_first{
            text-align: left;
            padding: 8px;
            font: normal 12px Arial, Helvetica, sans-serif; 
            border: solid 1px #FE9A2E;
        }

        tr:nth-child(even){background-color: #f2f2f2}

        th {
            background-color: #FE9A2E;
            color: white;
            font-weight: bold;
        }
     }
    
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        text-align: center;
        padding: 8px;
        font: normal 12px Arial, Helvetica, sans-serif; 
        border: solid 1px #FE9A2E;
    }

    tr:nth-child(even){background-color: #f2f2f2}

    th {
        background-color: #FE9A2E;
        color: white;
    }
        
    body {
        font: normal 10px Arial, Helvetica, sans-serif; 
    }

</style>

</head>
  <body>
<!--
<table>
    @foreach($registros_totales as $r)
    <tr>
    <td>{{$r->razon}}</td><td>{{$r->id}}</td><td>{{$r->pagado_bnd}}</td><td>{{$r->adeudo_planeado}}</td><td>{{$r->concepto}}</td>
    <td>{{$r->pago_calculado_adeudo}}</td><td>{{$r->caja}}</td><td>{{$r->borrado_c}}</td><td>{{$r->borrado_cln}}</td><td></td>
    <td>{{$r->st_cliente_id}}</td><td>{{$r->st_seguimiento_id}}</td>
    </tr>        
    @endforeach
</table>
-->
<table border="0" width="100%" >
            <td border="0" align="center"  >
                <h3>
                    Maestro
                </h3>
            </td>
</table>

<div class="datagrid">
    <table border="1" width="100%" >
       <!-- <thead >
        <th><strong>Plantel</strong></th><th><strong>Clientes Activos</strong></th><th><strong>Concepto</strong></th>
        <th><strong>Clientes Con Pago</strong></th><th><strong>Monto Pagado</strong></th><th><strong>Porcentaje Pagado</strong></th>
        <th><strong>Deudores</strong></th><th><strong>Monto Deuda(Estimacion Planeada)</strong></th><th><strong>Porcentaje Deuda</strong></th>
        <th><strong>Bajas Con pago</strong></th>
        </thead>
    -->
        <tbody>
            <?php $total=['concepto'=>"",'clientes_activos'=>0,'clientes_pagados'=>0,'total_monto_pagado'=>0,'deudores'=>0,'monto_deuda'=>0,'bajas_pagadas'=>0]; ?>
            @foreach($lineas_procesadas as $registro)
            @if($registro['concepto']=="Total")
            <tr>
                <th><strong>Plantel</strong></th><th><strong>Clientes Activos</strong></th><th><strong>Concepto</strong></th>
                <th><strong>Clientes Con Pago</strong></th><th><strong>Monto Pagado</strong></th><th><strong>Porcentaje Pagado</strong></th>
                <th><strong>Deudores</strong></th><th><strong>Monto Deuda(Estimacion Planeada)</strong></th><th><strong>Porcentaje Deuda</strong></th>
                <th><strong>Bajas Con pago</strong></th>
            </tr>
            @endif
            <tr>
                <td>{{$registro['plantel']}}</td>
                <td>{{$registro['clientes_activos']}}</td>
                <td>{{$registro['concepto']}}</td>
                <td>{{$registro['clientes_pagados']}}</td>
                <td> {{number_format($registro['total_monto_pagado'],2)}}</td>
                <td> {{ round($registro['porcentaje_pagado'],2)}}</td>
                <td> {{$registro['deudores']}}</td>
                <td> {{number_format($registro['monto_deuda'],2)}}</td>
                <td> {{round($registro['porcentaje_deudores'],2)}}</td>
                <td> {{$registro['bajas_pagadas']}}</td>
            </tr>
            <?php 
            if($registro['concepto']=="Total"){
                $total['clientes_activos']=$total['clientes_activos']+$registro['clientes_activos'];
                $total['clientes_pagados']=$total['clientes_pagados']+$registro['clientes_pagados'];
                $total['total_monto_pagado']=$total['total_monto_pagado']+$registro['total_monto_pagado'];
                $total['deudores']=$total['deudores']+$registro['deudores'];
                $total['monto_deuda']=$total['monto_deuda']+$registro['monto_deuda'];
                $total['bajas_pagadas']=$total['bajas_pagadas']+$registro['bajas_pagadas'];
            }
            ?>
            @endforeach
            <tr class="tr_first">
                <th>Sumas</th>
                <th>{{$total['clientes_activos']}}</th>
                <th></th>
                <th>{{$total['clientes_pagados']}}</th>
                <th> {{number_format($total['total_monto_pagado'],2)}}</th>
                <th> </th>
                <th> {{$total['deudores']}}</th>
                <th> {{number_format($total['monto_deuda'],2)}}</th>
                <th> </th>
                <th> {{$total['bajas_pagadas']}}</th>
            </tr>
        </tbody>
    </table>
    
</div>

  </body>
</html>


