<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Analitica Actividades</title>
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>

        <!-- external libs from cdnjs -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

        <!-- PivotTable.js libs from ../dist -->
        <link rel="stylesheet" type="text/css" href="{{asset('bower_components\AdminLTE\plugins\pivottable-master\dist\pivot.css')}}">
        <script type="text/javascript" src="{{asset('bower_components\AdminLTE\plugins\pivottable-master\dist\pivot.js')}}"></script>
        <script type="text/javascript" src="{{asset('bower_components\AdminLTE\plugins\pivottable-master\dist\pivot.es.js')}}"></script>
        <script type="text/javascript" src="{{asset('bower_components\AdminLTE\plugins\pivottable-master\dist\gchart_renderers.js')}}"></script>
        <style>
            body {font-family: Verdana;}
        </style>
        <style>
        h1, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
        </style>
        <!-- optional: mobile support with jqueryui-touch-punch -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

    </head>
    <body>
        <script src="{{asset('bower_components\AdminLTE\plugins\highChartTable\highChartTable.js')}}jquery.highchartTable.js" type="text/javascript"></script>
        <script type="text/javascript">
        // This example uses a function to provide the input values to pivot()
        google.load("visualization", "1", {packages:["corechart", "charteditor"]});
        $(function () {
            var renderers = $.extend($.pivotUtilities.renderers,
                $.pivotUtilities.gchart_renderers);

            var rawData=<?php 
                //echo $datos_grafica;
            ?>;

            var sum = $.pivotUtilities.aggregatorTemplates.sum;
            var numberFormat = $.pivotUtilities.numberFormat;
            var intFormat = numberFormat({digitsAfterDecimal: 0});
                
            var inputFunction = function (callback) {
                rawData.forEach(function (element, index) {
                    callback({
                        Empleado: element.empleado,
                        Estatus: element.estatus,
                        Total: element.total,
                    });
                });
            };

            /*$("#output").pivot(inputFunction, {
                rows: ["Plantel","Empleado"], 
                cols: ['Especialidad','Meta', 'Nivel', 'Grado'],
            });*/
            $("#output").pivotUI(inputFunction, {
                //renderers: renderers,
                rows: ["Empleado"], 
                cols: ['Estatus'],
                aggregator: sum(intFormat)(["Total"])
            },false, "es");

        });
        </script>

        <div id="output" style="margin: 30px;"></div>

        <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <th>Empleado</th><th>Estatus</th><th>Cantidad</th>
            </thead>
            <tbody>
                @foreach($a_2 as $r)
                <tr>
                    <td>{{$r->empleado}}</td>
                    <td>{{$r->estatus}}</td>
                    <td>{{$r->total}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </div>
    </body>
</html>
