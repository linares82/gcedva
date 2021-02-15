<html>
  <head>
      <style>
        h1, h3, h4, h5, th { text-align: center; font-family: Segoe UI;}
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    
    
  </head>
  <body>
    <div class="datagrid">
        <h3>Concretados</h3>
        
        <table class="table table-condensed table-striped">
          
          <thead>
              <th>Plantel</th><th>Concretados</th><th>Meta</th><th>Porcentaje Alcanzado</th>
          </thead>
          <tbody>    
            @foreach ($totales as $total)
            <tr>
              <td>{{ $total->razon }}</td><td>{{ $total->total_matriculas }}</td><td>{{ is_null($total->meta_total) ? 0 : $total->meta_total }}</td>
              <td>{{ round(($total->total_matriculas*100)/$total->meta_total,0) }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div>
          <div id="columnchart_material" style="width:auto;height:300px;padding:30px;margin-right:auto;margin-left:auto;"></div>
        </div>
        

        <h3>Detalle</h3>
        <table class="table table-condensed table-striped">
          <thead>
            <th>No.</th>
              <th>Plantel</th><th>Matricula</th><th>Estatus</th><th>Fecha Caja</th><th>Concepto</th>
          </thead>
          <tbody>
            @php
                $plantel="";
                $id=0;
            @endphp    
            @foreach ($detalle as $ln)
            <tr>
              @if($plantel<>$ln->plantel_id and $plantel<>"")
          </tbody>
        </table>

        <div>
          <div id="gauge_{{$plantel}}" style="width:200px; height: 200px;padding:30px;margin-right:auto;margin-left:auto;"></div>
        </div>
        

        <h3>Detalle</h3>
        <table class="table table-condensed table-striped">
          <thead>
            <th>No.</th>
              <th>Plantel</th><th>Matricula</th><th>Estatus</th><th>Fecha Caja</th><th>Concepto</th>
          </thead>
          <tbody>
              @php
                  $id=0;
              @endphp
              @endif
              <td>{{ ++$id }}</td>
              <td>{{ $ln->razon }}</td><td>{{ $ln->matricula }}</td><td>{{ $ln->st_cliente }}</td>
              <td>{{ $ln->fecha_caja }}</td><td>{{ $ln->concepto }}</td>
            </tr>
            @php
                $plantel=$ln->plantel_id;
            @endphp
            @endforeach
            </tbody>
        </table>
        <div>
          <div id="gauge_{{$ln->plantel_id}}" style="width:200px; height: 200px;padding:30px;margin-right:auto;margin-left:auto;"></div>
        </div>
        
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <script type="text/javascript">
    google.charts.load("current", {packages:['corechart','bar','gauge']});
    google.charts.setOnLoadCallback(drawChart);
    
    @foreach($totales as $total)
    google.setOnLoadCallback(function() { drawChartGauge('gauge_{{$total->id}}', {{ round(($total->total_matriculas*100)/$total->meta_total,0) }}); });
    @endforeach
    

    function drawChart() {
      var data = google.visualization.arrayToDataTable([
        ['Plantel','Concretados','Meta'],
        @foreach($totales as $total)
          ['{{ $total->razon }}', 
            {{ $total->total_matriculas }}, 
            {{ is_null($total->meta_total) ? 0 : $total->meta_total }}
          ],
        @endforeach
      ]);

      var options = { 
          chart: {
            title: 'Clientes Concretados Por Plantel',
            subtitle: 'Comparativo con Meta',
          },
          colors: [ '#000CFF', '#1b9e77', '#7570b3']
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
  }

  function drawChartGauge(id_div, concretados) {
    //console.log(concretados);
  var data = google.visualization.arrayToDataTable([
    ['Etiqueta', 'Valor'],
    ['Concretados', concretados]
  ]);

  var options = {    
    redFrom: 0, redTo: 70,
    yellowFrom:70, yellowTo: 90,
    greenFrom:90, greenTo: 100,
    minorTicks: 10
  };

  var chart = new google.visualization.Gauge(document.getElementById(id_div));
  chart.draw(data, options);
}
  
  </script>
  </body>
</html>


