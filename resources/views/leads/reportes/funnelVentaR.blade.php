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

<div class="datagrid">    
    <table border="0" width="100%" >
            <td border="0" align="center"  >
                <h3>
                    Funnel Venta Plantel del {{ $datos['fecha_f'] }} al {{ $datos['fecha_t'] }}
                </h3>
            </td>
    </table>
    <table border="1" width="100%" >
        <thead>
            <tr>
                <th>Plantel</th>
                <th>Leads</th>
                <th>Prospectos Creados</th>
                <th>Prospectos en Seguimiento</th>
                <th>Prospectos con Promesa de Pago</th> 
                <th>Clientes</th>
                <th>Prospectos Descartados</th>
                <th>Leads Rechazados</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros_plantel as $registro)
                <tr>
                    <td>{{ $registro['plantel'] }}</td>
                    <td>{{ $registro['leads_creados'] }}</td>
                    <td>{{ $registro['prospectos_creados'] }}</td>
                    <td>{{ $registro['prospectos_seguimiento'] }}</td>
                    <td>{{ $registro['prospectos_promesa_pago'] }}</td>
                    <td>{{ $registro['clientes'] }}</td>
                    <td>{{ $registro['prospectos_descartado'] }}</td>
                    <td>{{ $registro['leads_rechazado'] }}</td>
                    <td>{{ $registro['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <br/>
    <table border="0" width="100%" >
            <td border="0" align="center"  >
                <h3>
                    Funnel Venta Empleados del {{ $datos['fecha_f'] }} al {{ $datos['fecha_t'] }}
                </h3>
            </td>
    </table>
    <table border="1" width="100%" >
        <thead>
            <tr>
                <th>Plantel</th>
                <th>Empleado</th>
                <th>Leads</th>
                <th>Prospectos Creados</th>
                <th>Prospectos en Seguimiento</th>
                <th>Prospectos con Promesa de Pago</th> 
                <th>Clientes</th>
                <th>Prospectos Descartados</th>
                <th>Leads Rechazados</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros_plantel_empleado as $registro)
                <tr>
                    <td>{{ $registro['plantel'] }}</td>
                    <td>{{ $registro['empleado'] }}</td>
                    <td>{{ $registro['leads_creados'] }}</td>
                    <td>{{ $registro['prospectos_creados'] }}</td>
                    <td>{{ $registro['prospectos_seguimiento'] }}</td>
                    <td>{{ $registro['prospectos_promesa_pago'] }}</td>
                    <td>{{ $registro['clientes'] }}</td>
                    <td>{{ $registro['prospectos_descartado'] }}</td>
                    <td>{{ $registro['leads_rechazado'] }}</td>
                    <td>{{ $registro['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <table border="0" width="100%" >
            <td border="0" align="center"  >
                <h3>
                    Funnel Venta Secciones del {{ $datos['fecha_f'] }} al {{ $datos['fecha_t'] }}
                </h3>
            </td>
    </table>
    <table border="1" width="100%" >
        <thead>
            <tr>
                <th>Plantel</th>
                <th>Seccion</th>
                <th>Prospectos Creados</th>
                <th>Prospectos en Seguimiento</th>
                <th>Prospectos con Promesa de Pago</th> 
                <th>Clientes</th>
                <th>Prospectos Descartados</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registros_seccion as $registro)
                <tr>
                    <td>{{ $registro['plantel'] }}</td>
                    <td>{{ $registro['seccion'] }}</td>
                    <td>{{ $registro['prospectos_creados'] }}</td>
                    <td>{{ $registro['prospectos_seguimiento'] }}</td>
                    <td>{{ $registro['prospectos_promesa_pago'] }}</td>
                    <td>{{ $registro['clientes'] }}</td>
                    <td>{{ $registro['prospectos_descartado'] }}</td>
                    <td>{{ $registro['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

  </body>
</html>


