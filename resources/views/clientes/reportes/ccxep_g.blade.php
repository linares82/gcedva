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
      title : 'Estatus de clientes por Municipio del plantel {{$p}}',
      vAxis: {title: 'Cantidad'},
      hAxis: {title: 'Municipios'},
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
                <?php $i++; ?>
                @if($i==1)
                <tr>
                    <th>{{$ln[0]}}</th><th>{{$ln[1]}}</th><th>{{$ln[2]}}</th><th>{{$ln[3]}}</th><th>{{$ln[4]}}</th>
                </tr> 
                @else
                <tr>
                    <td>{{$ln[0]}}</td><td>{{$ln[1]}}</td><td>{{$ln[2]}}</td><td>{{$ln[3]}}</td><td>{{$ln[4]}}</td>
                </tr>     
                @endif
                @endforeach
            </tbody>
        </table>
    </div>
    
  </body>
</html>
