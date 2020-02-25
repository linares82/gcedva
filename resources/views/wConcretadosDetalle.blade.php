<html>
    <head>
        <style>
            
            @media print {
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 9px;
                }

                td, th {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 10px;
                }

                tr:nth-child(even) {
                    background-color: #dddddd;
                }
            }
              h1, h3, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge gray; }
        th { font-size: 11px; background: #0046c3; color: #fff; max-width: 400px; padding: 2px 5px; }
        td { font-size: 10px; padding: 2px 10px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #fff; }

        </style>

<link rel="stylesheet"
href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
crossorigin="anonymous">

</head>

    </head>
    <body style="padding:10px;">
        <div id="printeArea">
        <h3> Concretados </h3>
            
        <table class="table table-condensed table-striped">
                <thead>
                    <th>Csc</th><th>Plantel</th><th>Meta Total</th><th>Cliente</th><th>Fecha</th> <th>Hora</th>
                </thead>
                @php
                    $indicador=0;
                @endphp
                @foreach($detalle1 as $linea)
                    <tr>
                    <td>{{++$indicador}}</td>
                    <td>{{$linea['razon']}}</td><td>{{$linea['meta_total']}}</td><td>{{$linea['cliente_id']}}</td>
                    <td>{{$linea['fecha']}}</td><td>{{$linea['hora']}}</td>
                    </tr>
                @php
                    $vMeta=$linea['meta_total'];
                @endphp    

                @endforeach      
                <tr><td colspan="5"><strong>Total</strong></td><td><strong>{{$indicador}}</strong> </td>
                    <tr><td colspan="5"><strong>Porcentaje</strong></td><td><strong>{{round(($indicador*100)/$linea['meta_total'],2)}}</strong> </td>    
                
            </table>
            <br>
            <div class="row">
            <div class="col-md-6">
                <h4>Periodos Cortos</h4>
                <div id="wResumenCorto" style="height: 150px;">
                    <div id='loading30' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                </div>
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Csc</th><th>Plantel</th><th>Meta Total</th><th>Cliente</th><th>Fecha</th> <th>Hora</th>
                    </thead>
                    @php
                        $indicador=0;
                    @endphp
                    @foreach($detalleCorto as $linea)
                        <tr>
                        <td>{{++$indicador}}</td>
                        <td>{{$linea['razon']}}</td><td>{{$linea['meta_total']}}</td><td>{{$linea['cliente_id']}}</td>
                        <td>{{$linea['fecha']}}</td><td>{{$linea['hora']}}</td>
                        </tr>
                    @php
                        $vMeta=$linea['meta_total'];
                    @endphp    
    
                    @endforeach      
                    <tr><td colspan="5"><strong>Total</strong></td><td><strong>{{$indicador}}</strong> </td>
                        <tr><td colspan="5"><strong>Porcentaje</strong></td><td><strong>{{round(($indicador*100)/$linea['meta_total'],2)}}</strong> </td>    
                    
                </table>
            </div >
            <div class="col-md-6">
                <h4>Periodos Largos</h4> 
                <div id="wResumenLargo" style="height: 150px;">
                    <div id='loading30' style='display: none'><img src="{{ asset('images/ajax-loader.gif') }}" title="Enviando" /></div> 
                </div>
                <table class="table table-condensed table-striped">
                    <thead>
                        <th>Csc</th><th>Plantel</th><th>Meta Total</th><th>Cliente</th><th>Fecha</th> <th>Hora</th>
                    </thead>
                    @php
                        $indicador=0;
                    @endphp
                    @foreach($detalleLargo as $linea)
                        <tr>
                        <td>{{++$indicador}}</td>
                        <td>{{$linea['razon']}}</td><td>{{$linea['meta_total']}}</td><td>{{$linea['cliente_id']}}</td>
                        <td>{{$linea['fecha']}}</td><td>{{$linea['hora']}}</td>
                        </tr>
                    @php
                        $vMeta=$linea['meta_total'];
                    @endphp    
    
                    @endforeach      
                    <tr><td colspan="5"><strong>Total</strong></td><td><strong>{{$indicador}}</strong> </td>
                        <tr><td colspan="5"><strong>Porcentaje</strong></td><td><strong>{{round(($indicador*100)/$linea['meta_total'],2)}}</strong> </td>    
                    
                </table>
            </div>
        </div>
        </div>

        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            
            google.charts.load('current', {'packages':['gauge']});
            google.charts.setOnLoadCallback(drawChart_wResumenCorto);
            google.charts.setOnLoadCallback(drawChart_wResumenLargo);

            function drawChart_wResumenCorto() {
                //var linea=JSON.parse(<?php echo $resumenCorto['p_avance'] ?>);
                
                var linea=<?php echo $resumenCorto['p_avance'] ?>;
                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Asistencia', linea],
                    ]);

                    var options = {
                    greenFrom:90, greenTo: 100,
                    yellowFrom:75, yellowTo: 90,
                    redFrom: 0, redTo: 75,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById("wResumenCorto"));

                    chart.draw(data, options);
            }

            function drawChart_wResumenLargo() {
                //var linea=JSON.parse(<?php echo $resumenLargo['p_avance'] ?>);
                var linea=<?php echo $resumenLargo['p_avance'] ?>;    

                    var data = google.visualization.arrayToDataTable([
                    ['Label', 'Value'],
                    ['Asistencia', linea],
                    ]);

                    var options = {
                    greenFrom:90, greenTo: 100,
                    yellowFrom:75, yellowTo: 90,
                    redFrom: 0, redTo: 75,
                    minorTicks: 5
                    };

                    var chart = new google.visualization.Gauge(document.getElementById("wResumenLargo"));

                    chart.draw(data, options);
            }
            
        </script>

    </body>
</html>

