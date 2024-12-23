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
                    Pagos de Bajas
                </h3>
            </td>
</table>

<div class="datagrid">
    <h3>
        Bajas X Plantel
    </h3>
    <table border="1" width="100%" >
        <thead>
            <th>Plantel</th><th>Bajas</th><th>Plantel</th><th>Call Center</th>
        </thead>
        <tbody>
            @php
                $plantel="";
                $bajas=0;
                $bajas_callcenter=0;
                $bajas_otras=0;
            @endphp
            @foreach($registros as $registro)
            @if($registro['razon']<>$plantel and !$loop->first)
            <tr>
                <td>{{$plantel}}</td><td>{{$bajas}}</td><td>{{$bajas_otras}}</td><td>{{$bajas_callcenter}}</td>
            </tr>
            @php
                $bajas=0;
                $bajas_callcenter=0;
                $bajas_otras=0;
            @endphp
            @endif
            @php
                $plantel=$registro['razon'];
                $bajas=$bajas+1;    
                if($registro['st_prospecto_id']==1){
                    $bajas_callcenter=$bajas_callcenter+1;
                }else{
                    $bajas_otras=$bajas_otras+1;
                }
            @endphp
            @endforeach
            <tr>
                <td>{{$registro['razon']}}</td><td>{{$bajas}}</td><td>{{$bajas_otras}}</td><td>{{$bajas_callcenter}}</td>
            </tr>
        </tbody>
    </table>

    <h3>
        Bajas X Plantel, Seccion y Ciclo
    </h3>
    <table border="1" width="100%" >
        <thead>
            <th>Plantel</th><th>Ciclo</th><th>Seccion</th><th>Bajas</th>
        </thead>
        <tbody>
            @php
                $plantel="";
                $seccion="";
                $ciclo="";
                $combinacion="";
                $bajas=0;
                $bajas_plantel=0;
            @endphp
            @foreach($registros as $registro)
            @if($registro['razon'].$registro['ciclo_matricula'].$registro['seccion']<>$combinacion and !$loop->first)
            <tr>
                <td>{{$plantel}}</td><td>{{$ciclo}}</td><td>{{$seccion}}</td><td>{{$bajas}}</td>
            </tr>
            @php
                $bajas=0;
            @endphp
            @endif
            @if($registro['razon']<>$plantel and !$loop->first)
            <tr>
                <td><strong>{{$plantel}}</strong></td><td></td><td></td><td><strong>{{$bajas_plantel}}</strong></td>
            </tr>
            @php
                $bajas_plantel=0;
            @endphp
            @endif
            @php
                $plantel=$registro['razon'];
                $seccion=$registro['seccion'];
                $ciclo=$registro['ciclo_matricula'];
                $combinacion=$registro['razon'].$registro['ciclo_matricula'].$registro['seccion'];
                $bajas=$bajas+1;    
                $bajas_plantel=$bajas_plantel+1;
            @endphp
            @endforeach
            <tr>
            <td>{{$plantel}}</td><td>{{$ciclo}}</td><td>{{$seccion}}</td><td>{{$bajas}}</td>
            </tr>
            <tr><td><strong>{{$plantel}}</strong></td><td></td><td></td><td><strong>{{$bajas_plantel}}</strong></td></tr>
        </tbody>
    </table>

    <h3>
        Bajas Detalle
    </h3>

    <table border="1" width="100%" >
        <thead>
            <tr>
                <th>No.</th>
                <th>Plantel</th>
                <th>Cliente Id</th>
                <th>A. Paterno</th>
                <th>A. Materno</th>
                <th>Nombre</th>
                <th>Tel.</th>
                <th>Celular</th>
                <th>Calle y No.</th>
                <th>Estatus Cliente</th>
                <th>Concepto</th>
                @permission('reportesCedva.restringido')
                <th>Pago Recibido</th>
                @endpermission
                <th>Csc. Caja</th>
                <th>Forma Pago</th>
                <th>F. Creacion Pago</th>
                <th>F. Pago</th>
                <th>F. Baja</th>
                <th>Justificacion</th>
                <th>Seguimiento T.</th>
                <th>Estatus Seguimiento</th>
                <th>Ciclo</th>
                <th>Seccion</th>
                <th>Asesor inscripcion</th>
                <th>Etapa Prospecto</th>
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
            @foreach($registros as $detalle)
                               
                <tr>   
                <td>{{++$consecutivo_linea}}</td>
                <td>{{$detalle['razon']}}</td>
                <td>{{$detalle['cliente_id']}}</td>
                <td>{{ $detalle['ape_paterno'] }}</td>
                <td>{{ $detalle['ape_materno'] }}</td>
                <td>{{ $detalle['nombre'] }} {{ $detalle['nombre2'] }}  </td>
                <td>{{ $detalle['tel_fijo'] }}</td>
                <td>{{ $detalle['tel_cel'] }}</td>
                <td>{{ $detalle['calle'] }} {{ $detalle['no_exterior'] }}</td>
                <td>{{ $detalle['st_cliente'] }}</td>
                <td>{{$detalle['concepto']}}</td>
                @permission('reportesCedva.restringido')
                <td>{{ $detalle['monto'] }}</td>
                @endpermission
                <td>{{$detalle['consecutivo']}}</td>
                <td>{{$detalle['forma_pago']}}</td>
                <td>{{$detalle['fecha_creacion']}}</td>
                <td>{{$detalle['fecha_pago']}}</td>
                <td>{{$detalle['fecha_baja']}}</td>
                <td>{{$detalle['justificacion']}}</td>
                <td>
                    @if(!is_null($detalle['ultima_tarea']))
                    {{$detalle['ultima_tarea']->asunto->name}} {{$detalle['ultima_tarea']->detalle}}
                    @endif
                </td>
                <td>{{$detalle['sts']}}</td>
                <td>{{$detalle['ciclo_matricula']}}</td>
                <td>{{$detalle['seccion']}}</td>
                <td>{{$detalle['emp_nombre']}} {{$detalle['emp_ape_paterno']}} {{$detalle['emp_ape_materno']}}</td>
                <td>{{$detalle['st_prospecto']}}</td>
                </tr>
                
                
                
            @endforeach
            @permission('reportesCedva.restringido')
            <tr><td>Total Alumnos Pagados</td><td></td></tr>
            <tr><td>Total monto pagado</td><td></td></tr>
            @endpermission
        </tbody>
    </table>
    
</div>

  </body>
</html>


