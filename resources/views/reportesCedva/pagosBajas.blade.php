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
                <th>Pago Recibido</th>
                <th>Csc. Caja</th>
                <th>Forma Pago</th>
                <th>F. Creacion Pago</th>
                <th>F. Pago</th>
                <th>F. Baja</th>
                <th>Justificacion</th>
                <th>Seguimiento T.</th>
                <th>Estatus Seguimiento</th>

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
                <td>{{ $detalle['monto'] }}</td>
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
                </tr>
                
                
                
            @endforeach
            <tr><td>Total Alumnos Pagados</td><td></td></tr>
            <tr><td>Total monto pagado</td><td></td></tr>
        </tbody>
    </table>
    
</div>

  </body>
</html>


