<html>
  <head>
      <style>
        h1, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawVisualization);

      function drawVisualization() {
        // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable(<?php echo $datos_grafica; ?>);

    var options = {
      title : 'Estatus por empleado del plantel {{$plantel}}',
      vAxis: {title: 'Cantidad de Clientes por Estatus'},
      hAxis: {title: 'Empleado'},
      seriesType: 'bars'
    };

    var chart = new google.visualization.ComboChart(document.getElementById('chart_div'));
    chart.draw(data, options);
  }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <tbody>
                <?php $i=0; ?>
                @foreach($tabla as $ln)
                <?php $i++;?>
                @if($i==1)
                <tr>
                    <th>{{$ln[0]}}</th><th>{{$ln[1]}}</th><th>{{$ln[2]}}</th><th>{{$ln[3]}}</th><th>{{$ln[4]}}</th><th>{{$ln[5]}}</th><th>{{$ln[6]}}</th><th>{{$ln[7]}}</th>
                </tr> 
                @else
                <tr>
                    <td>
                    @if(isset($ln[0]))
                    {{$ln[0]}}
                    @else
                    0
                    @endif
                    </td>
                    <td>
                      @if(isset($ln[1]))
                    {{$ln[1]}}
                    @else
                    0
                    @endif
                    </td>
                    <td>
                      @if(isset($ln[2]))
                    {{$ln[2]}}
                    @else
                    0
                    @endif
                    </td>
                    <td>
                      @if(isset($ln[3]))
                    {{$ln[3]}}
                    @else
                    0
                    @endif
                    </td>
                    <td>
                      @if(isset($ln[4]))
                    {{$ln[4]}}
                    @else
                    0
                    @endif
                    </td>
                    <td>
                      @if(isset($ln[5]))
                    {{$ln[5]}}
                    @else
                    0
                    @endif
                    </td>
                    <td>
                      @if(isset($ln[6]))
                    {{$ln[6]}}
                    @else
                    0
                    @endif
                    </td>
                    <td>
                      @if(isset($ln[7]))
                    {{$ln[7]}}
                    @else
                    0
                    @endif
                    </td>
                </tr>     
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    
  </body>
</html>
