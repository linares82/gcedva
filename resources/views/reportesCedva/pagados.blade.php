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
                    Pagados
                </h3>
            </td>
</table>

<div class="datagrid">
    <table border="1" width="100%" >
        <thead>
            <tr>
                <th>No.</th>
                <th>Plantel</th>
                <th>Cliente Id</th>
                <th>Matricula</th>
                <th>Seccion</th>
                <th>A. Paterno</th>
                <th>A. Materno</th>
                <th>Nombre</th>
                <th>Estatus Cliente</th>
                <th>Concepto</th>
                @permission('adeudos.maestroPagosConMontos')
                <th>Pago Recibido</th>
                @endpermission  
                <th>Csc. Caja</th>
                <th>Usuario Pago</th>
                <th>Beca</th>
                
            </tr>
        </thead>
        <tbody>
            @php
                $consecutivo_linea=0;
                $caja_aux="";
                $suma=0;
                $pagos_suma=0;
                $plantel="";
                $suma_plantel=0;
                $concepto="";
                $suma_concepto=0;
            @endphp 
            @foreach($lineas_detalle as $detalle)
                @permission('adeudos.maestroPagosConMontos')    
                @if($plantel<>"" and $plantel<>$detalle['razon'])
                <tr><td>Suma Plantel</td><td>{{ $suma_plantel }}</td></tr>
                @php
                    $suma_plantel=0;
                @endphp
                <tr>   
                @endif
                @if($concepto<>"" and $concepto<>$detalle['concepto'])
                <tr><td>Suma Concepto</td><td>{{ $suma_concepto }}</td></tr>
                @php
                    $suma_concepto=0;
                @endphp
                <tr>   
                @endif
                @endpermission
                @if($caja_aux<>$detalle['caja'])
                @php
                    $beca=App\AutorizacionBeca::where('cliente_id',$detalle['cliente_id'])
                    ->orderBy('autorizacion_becas.id','Desc')
                    ->where('autorizacion_becas.st_beca_id',4)
                    ->take(1)
                    ->first();
                    //dd($beca);
                    if(!is_null($beca) and !is_null($beca->lectivo_id)){
                        $fecha_inicio=Carbon\Carbon::createFromFormat('Y-m-d',$beca->lectivo->inicio);
                        $fecha_fin=Carbon\Carbon::createFromFormat('Y-m-d',$beca->lectivo->fin);
                        $fecha_adeudo=Carbon\Carbon::createFromFormat('Y-m-d',$detalle['fecha_pago']);

                        $mesAdeudo = Carbon\Carbon::createFromFormat('Y-m-d', $detalle['fecha_pago'])->month;
                        $anioAdeudo = Carbon\Carbon::createFromFormat('Y-m-d', $detalle['fecha_pago'])->year;

                        $mesInicio = Carbon\Carbon::createFromFormat('Y-m-d', $beca->lectivo->inicio)->month;
                        $anioInicio = Carbon\Carbon::createFromFormat('Y-m-d', $beca->lectivo->inicio)->year;
                        $mesFin = Carbon\Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->month;
                        $anioFin = Carbon\Carbon::createFromFormat('Y-m-d', $beca->lectivo->fin)->year;
                    }    
                @endphp
                <tr>   
                <td>{{++$consecutivo_linea}}</td>
                <td>{{$detalle['razon']}}</td>
                <td>{{$detalle['cliente_id']}}</td>
                <td>{{ $detalle['matricula'] }}</td>
                <td> {{ $detalle['seccion'] }} </td>
                <td>{{ $detalle['ape_paterno'] }}</td>
                <td>{{ $detalle['ape_materno'] }}</td>
                <td>{{ $detalle['nombre'] }} {{ $detalle['nombre2'] }}  </td>
                <td>{{ $detalle['st_cliente'] }}</td>
                <td>{{$detalle['concepto']}}</td>
                @permission('adeudos.maestroPagosConMontos')
                @php
                    $pagos_suma=App\Pago::where('caja_id',$detalle['caja'])->whereNull('deleted_at')->sum('monto');
                @endphp
                <td>{{$pagos_suma}}</td>
                @endpermission
                
                <td>{{$detalle['consecutivo']}}</td>
                <td>
                @php
                    if(is_int($detalle['caja'])){
                    $pago=App\Pago::where('caja_id', $detalle['caja'])->first();    
                    }
                    if(!is_null($pago)){
                    echo $pago->usu_alta->name;
                    }
                @endphp
                </td>
                @if(!is_null($beca)) 
                
                    @if(
                        (($beca->lectivo->inicio <= $fecha_adeudo and $beca->lectivo->fin >= $fecha_adeudo) or
                        (($anioInicio = $anioAdeudo or $mesInicio <= $mesAdeudo) and ($anioFin = $anioAdeudo and $mesFin >= $mesAdeudo)) or
                        (($anioInicio < $anioAdeudo or $mesInicio >= $mesAdeudo) and ($anioFin >= $anioAdeudo and $mesFin >= $mesAdeudo))) and
                        $beca->aut_dueno == 4 and
                        is_null($beca->deleted_at)
                    )
                    <td>
                        {{$beca->monto_mensualidad}}
                    </td>
                    @else
                    <td></td>
                    @endif
                @else
                    <td></td>
                @endif
                
                </tr>
                @php
                    $suma=$suma+$pagos_suma;
                    $caja_aux=$detalle['caja'];
                    $plantel=$detalle['razon'];
                    $suma_plantel=$suma_plantel+round($pagos_suma);
                    $concepto=$detalle['concepto'];
                    $suma_concepto=$suma_concepto+round($pagos_suma);
                @endphp
                @endif
                
            @endforeach
            <tr><td>Total Alumnos Pagados</td><td>{{ $consecutivo_linea }}</td></tr>
            <tr><td>Total monto pagado</td><td>{{ number_format($suma, 2) }}</td></tr>
        </tbody>
    </table>
    
</div>

  </body>
</html>


