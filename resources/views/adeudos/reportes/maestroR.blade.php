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
    <br/>
    @if($datos['detalle_f']<4)
    <table border="1" width="100%" >
        <thead>
            <tr>
                <th>No.</th>
                <th>Plantel</th>
                <th>Cliente Id</th>
                <th>Cliente</th>
		<th></th>
                <th>Matricula</th>
                <!--<th>Pagado</th>
                <th>Monto Planeado</th>-->
                <th>Turno</th>
                <th>F. Planeada Pago</th>
                <th>Concepto</th>
                <th>Pago Recibido</th>
                <th>Csc. Caja</th>
                <th>Beca</th>
                <th>Estatus Cliente</th>
                <!--<th>Consecutivo Caja</th>
                <th>Caja borrada</th>
                <th>Linea de Caja Borrada</th>
                <th>St. Cliente</th>
                <th>St. Seguimiento</th>-->
            </tr>
        </thead>
        <tbody>
            @php
                $consecutivo_linea=1;
            @endphp 
            @foreach($lineas_detalle as $detalle)
            @php
                $beca=App\AutorizacionBeca::where('cliente_id',$detalle['id'])
                ->orderBy('autorizacion_becas.id','Desc')
                ->where('autorizacion_becas.st_beca_id',4)
                ->take(1)
                ->first();
                //dd($beca);
                if(!is_null($beca)){
                    $fecha_inicio=Carbon\Carbon::createFromFormat('Y-m-d',$beca->lectivo->inicio);
                    $fecha_fin=Carbon\Carbon::createFromFormat('Y-m-d',$beca->lectivo->fin);
                    $fecha_adeudo=Carbon\Carbon::createFromFormat('Y-m-d',$detalle['fecha_pago']);
                }
                
            @endphp
            <tr>   
            <td>{{$consecutivo_linea++}}</td>
            <td>{{$detalle['razon']}}</td>
            <td>{{$detalle['id']}}</td>
            <td>{{ $detalle['nombre'] }} {{ $detalle['nombre2'] }} {{ $detalle['ape_paterno'] }} {{ $detalle['ape_materno'] }}</td>
	        <td> {{$detalle['usu_alta_id']}} </td>
            <td>{{ $detalle['matricula'] }}</td>
            <td>{{ $detalle['turno'] }}</td>
            <td>{{ $detalle['fecha_pago'] }}</td>
            <!--
            <td>
                @if($detalle['pagado_bnd']==0)
                NO
                @elseif($detalle['pagado_bnd']==1)
                SI
                @endif
            </td>
            <td>{{$detalle['adeudo_planeado']}}</td>-->
            <td>{{$detalle['concepto']}}</td>
            <!--<td>{{$detalle['pago_calculado_adeudo']}}</td>-->
	    <td>{{$detalle['monto_pago']}}</td>
        <td>{{$detalle['consecutivo']}}</td>
        @if(!is_null($beca)) 
        @if($fecha_adeudo->greaterThanOrEqualTo($fecha_inicio) and $fecha_adeudo->lessThanOrEqualTo($fecha_fin))
        <td>{{$beca->monto_mensualidad}}</td>
        @else
        <td></td>
        @endif
        @else
        <td></td>
        @endif
        <td>{{ $detalle['st_cliente'] }}</td>
<!--            
            <td>{{$detalle['borrado_c']}}</td>
            <td>{{$detalle['borrado_cln']}}</td>
            <td>{{$detalle['st_cliente']}}</td>
            <td>{{$detalle['st_seguimiento']}}</td>
            -->
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</div>

  </body>
</html>


