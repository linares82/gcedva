<html>
  <head>

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
                    Adeudos
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
                @permission('adeudos.maestroAdeudoConMontos')
                <th>Pago Planeado</th>
                @endpermission
                
            </tr>
        </thead>
        <tbody>
            @php
                $consecutivo_linea=0;
                $suma=0;
                $plantel="";
                $suma_plantel=0;
                $concepto="";
                $suma_concepto=0;
            @endphp 
            
            @foreach($lineas_detalle as $detalle)
            @permission('adeudos.maestroAdeudoConMontos')    
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
            <td>{{++$consecutivo_linea}}</td>
            <td>{{$detalle['razon']}}</td>
            <td>{{$detalle['id']}}</td>
            <td>{{ $detalle['matricula'] }}</td>
            <td>{{ $detalle['seccion'] }} </td>
            <td>{{ $detalle['ape_paterno'] }}</td>
            <td>{{ $detalle['ape_materno'] }}</td>
            <td>{{ $detalle['nombre'] }} {{ $detalle['nombre2'] }}  </td>
            <td>{{ $detalle['st_cliente'] }}</td>
            <td>{{$detalle['concepto']}}</td>
            @permission('adeudos.maestroAdeudoConMontos')    
            <td>{{ round($detalle['adeudo_planeado'])}}</td>
            @endpermission
            </tr>
            @php
                $suma=$suma+round($detalle['adeudo_planeado']);
                $plantel=$detalle['razon'];
                $suma_plantel=$suma_plantel+round($detalle['adeudo_planeado']);
                $concepto=$detalle['concepto'];
                $suma_concepto=$suma_concepto+round($detalle['adeudo_planeado']);
            @endphp
            @endforeach
            @permission('adeudos.maestroAdeudoConMontos')    
            <tr><td>Total Alumnos Con Adeudo</td><td>{{ $consecutivo_linea }}</td></tr>
            <tr><td>Total Adeudo</td><td>{{ number_format($suma,2) }}</td></tr>
            @endpermission
        </tbody>
    </table>
    
</div>

  </body>
</html>


