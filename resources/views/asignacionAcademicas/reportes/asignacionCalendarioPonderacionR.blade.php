<!DOCTYPE html>
<html>
    <head>
        <title>Pivot Demo</title>
        
        <style>
            h1, h3, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; border: thin ridge grey; }
        .tbl1 th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; font-size: 12px;}
        .tbl1 td { font-size: 12px; padding: 5px 20px; color: #000; }
        .tbl1 tr { background: #b8d1f3; }
        .tbl1 tr:nth-child(even) { background: #dae5f4; }
        .tbl1 tr:nth-child(odd) { background: #b8d1f3; }
      
        table.blueTable {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
          }
          table.blueTable .td1{
            height: 100px;
          }
          table.blueTable .tdw{
            width: 33%;
          }
          table.blueTable td, table.blueTable th {
            border: 1px solid #AAAAAA;
          }
          
          table.blueTable thead th {
            font-weight: bold;
            text-align: center;
          }

            .SaltoDePagina{
             page-break-after: always;
             padding:10px;
            }
          </style>

        <!-- optional: mobile support with jqueryui-touch-punch -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    </head>
    <body>
        <h1>Calendarios por asignacion y ponderacion</h1>
        <table class="blueTable tbl1">
            <thead>
                <tr>
                    <th>Plantel</th>
                    <th>Lectivo</th>
                    <th>Maestro</th>
                    <th>Materia</th>
                    <th>Grupo</th>
                    <th>Ponderacion</th>
                    <th>Inicio</th>
                    <th>Fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($res as $r)
                <tr>
                    <td>{{ $r->razon }}</td>
                    <td>{{ $r->lectivo }}</td>
                    <td>{{ $r->nombre }} {{ $r->ape_paterno }} {{ $r->ape_materno }}</td>
                    <td>{{ $r->materia }}</td>
                    <td>{{ $r->grupo }}</td>
                    <td>{{ $r->carga_ponderacion }}</td>
                    <td>{{ $r->fec_inicio }}</td>
                    <td>{{ $r->fec_fin }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <script type="text/javascript">
        
        </script>

        

        <div id="output" style="margin: 30px;"></div>

    </body>
</html>
