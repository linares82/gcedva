<html>

<head>
    <link href="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.min.css')}}" rel="stylesheet" />

    <style>
        @media print {
            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                text-align: left;
                padding: 8px;
                font: normal 12px Arial, Helvetica, sans-serif;
                border: solid 1px #FE9A2E;
            }

            tr:nth-child(even) {
                background-color: #f2f2f2
            }

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

        th,
        td {
            text-align: center;
            padding: 8px;
            font: normal 12px Arial, Helvetica, sans-serif;
            border: solid 1px #FE9A2E;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2
        }

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

    <table border="0" width="100%">
        <td border="0" align="center">
            <h3>
                Pagos y Adeudos
            </h3>
        </td>
    </table>

    <div class="datagrid">
        <table border="1" width="100%">
            <thead>
            <th><strong>Csc</strong></th>
                <th><strong>Plantel</strong></th>
                <th><strong>Cliente</strong></th>
                <th><strong>Estatus</strong></th>
                <th><strong>Pagado</strong></th>
                
            </thead>
            <tbody>
                @php
                    $i=0;
                    $suma_monto=0;
                @endphp
                @foreach($cuenta_detalle as $cd)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$cd->razon}}</td>
                        <td>{{$cd->cliente_id}}</td>
                        <td>{{$cd->estatus}}</td>
                        <td>{{$cd->pagado_bnd}}</td>
                        
                    </tr>
                    @php
                        $suma_monto=$suma_monto+$cd->monto;
                    @endphp    
                @endforeach
                    
            </tbody>
        </table>

        <br/>

        <table border="1" width="100%">
            <thead>
            <th><strong>Csc</strong></th>
                <th><strong>Plantel</strong></th>
                <th><strong>Cliente</strong></th>
                <th><strong>Estatus</strong></th>
                <th><strong>Concepto</strong></th>
                <th><strong>Fecha Planeada</strong></th>
                <th><strong>Pagado</strong></th>
                <th><strong>Monto</strong></th>
            </thead>
            <tbody>
                @php
                    $i=0;
                    $suma_monto=0;
                @endphp
                @foreach($tabla as $r)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$r['razon']}}</td>
                        <td>{{$r['cliente_id']}}</td>
                        <td>{{$r['estatus']}}</td>
                        <td>{{$r['concepto']}}</td>
                        <td>{{$r['fecha_planeada']}}</td>
                        <td>{{$r['pagado_bnd']}}</td>
                        <td>{{$r['monto']}}</td>
                    </tr>
                    @php
                        $suma_monto=$suma_monto+$cd->monto;
                    @endphp    
                @endforeach
                    
            </tbody>
        </table>

    </div>

    

    
</body>

</html>