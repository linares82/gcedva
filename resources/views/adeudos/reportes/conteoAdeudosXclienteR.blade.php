<html>
  <head>
      <link href="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.min.css')}}" rel="stylesheet" />

<style>
    @media print {
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
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
                    Conteo de adeudos por cliente
                </h3>
            </td>
</table>

<div class="datagrid">
    <table border="1" width="100%" >
        <thead >
        <th><strong>Plantel</strong></th><th><strong>Cliente</strong></th>
        <th><strong>Estatus</strong></th><th><strong>Adeudos</strong></th>
        
        </thead>
        <tbody>
            @foreach($adeudos as $registro)
            <tr>
                <td>{{$registro['razon']}}</td>
                <td>{{$registro['cliente_id']}}</td>
                <td>{{$registro['estatus']}}</td>
                <td>{{$registro['adeudos_pendientes']}}</td>
            </tr>
            
            @endforeach
        </tbody>
    </table>
    
</div>

  </body>
</html>


