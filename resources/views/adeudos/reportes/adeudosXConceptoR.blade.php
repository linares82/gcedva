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
                    Adeudos por Concepto
                </h3>
            </td>
</table>

<div class="datagrid">
    <table border="1" width="100%" >
        <thead>
            <tr>
                <th>Plantel</th><th>Seccion</th><th>Total Pagados</th><th>Total No Pagados</th>
            </tr>
        </thead>
        <tbody>
            @php
                $suma_p=0;
                $suma_np=0;
            @endphp
            @foreach($totales as $total)
            <tr>
                <td>{{ $total['plantel'] }}</td>
                <td>{{ $total['seccion'] }}</td>
                <td>{{ $total['total_pagados'] }}</td>
                <td>{{ $total['total_no_pagados'] }}</td>
                @php
                $suma_p=$suma_p+$total['total_pagados'];
                $suma_np=$suma_np+$total['total_no_pagados'];
                @endphp
            </tr>
            @endforeach
            <tr>
                <td colspan="2">Totales</td><td>{{ $suma_p }}</td><td>{{ $suma_np }}</td>
            </tr>
        </tbody>
    </table>
    <br/>
    
    <table border="1" width="100%" >
        <thead>
            <tr>
                <th>No.</th>
                <th>Plantel</th>
                <th>Seccion</th>
                <th>Cliente Id</th>
                <th>Cliente</th>
                <th>Matricula</th>
                <th>Concepto</th>
                <th>Pagado</th>
                <th>F. Caja</th>
                <th>Monto Planeado</th>
                <th>Monto Caja</th>
            </tr>
        </thead>
        <tbody>
            @php
                $i=0;
            @endphp
            @foreach($detalle as $linea)
            <tr>
                <td>{{++$i}}</td><td>{{$linea->razon}}</td><td>{{$linea->seccion}}</td>
                <td>{{$linea->cliente_id}}</td>
                <td>{{$linea->nombre}} {{$linea->nombre2}} {{$linea->ape_paterno}} {{$linea->ape_materno}}</td>
                <td>{{$linea->matricula}}</td><td>{{$linea->concepto}}</td>
                <td>
                    @if($linea->pagado_bnd==1)
                        Si
                    @else
                        No
                    @endif
                </td>
                <td>@if($linea->pagado_bnd==1)
                    {{$linea->caja_fecha}}</td>
                @endif
                    
                <td>{{$linea->monto}}</td><td>{{$linea->total}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
</div>

  </body>
</html>


