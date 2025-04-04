<!DOCTYPE html>
<html>
    <head>
        <title>Pivot Demo</title>
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
            h1, h3, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; border: thin ridge grey; }
        .tbl1 th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; font-size: 12px;}
        .tbl1 td { font-size: 12px; padding: 5px 20px; color: #000; }
        .tbl1 tr { background: #b8d1f3; }
        .tbl1 tr:nth-child(even) { background: #dae5f4; }
        .tbl1 tr:nth-child(odd) { background: #b8d1f3; }
      
        table.blueTable {
            width: 60%;
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
        <h1>Horas por maestro</h1>
        
        <table class="tbl1">
            <thead>
                <th>Plantel</th><th>Lectivo</th><th>Grupo</th><th>Materia</th>
                <th>Docente</th><th>Asignacion</th><th>Horas Clase</th>
            </thead>
            <tbody>
                @foreach($resultados as $registro)
                <tr>
                    @php
                        //dd($registro['fecha_clase'][0]);
                    @endphp
                    <td>{{$registro['plantel']}}</td><td>{{$registro['lectivo']}} ({{$registro['inicio']}} a {{$registro['fin']}})</td><td>{{$registro['grupo']}}</td><td>{{$registro['materia']}}</td>
                    <td>{{$registro['empleado']}}</td><td>{{$registro['asignacion_academica_id']}}</td><td>{{$registro['duracion_clases_total']}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <script type="text/javascript">
        // This example uses a function to provide the input values to pivot()
        google.load("visualization", "1", {packages:["corechart", "charteditor"]});
        $(function () {
            var renderers = $.extend($.pivotUtilities.renderers,
                $.pivotUtilities.gchart_renderers);

            var rawData=<?php 
                echo $datos;
            ?>;
            var inputFunction = function (callback) {
                rawData.forEach(function (element, index) {
                    callback({
                        Plantel: element.plantel,
                        Periodo: element.periodo_estudio_id
                        Asignacion: element.asignacion_academica_id
                        Empleado: element.empleado,
                        Grupo: element.grupo,
                        Materia: element.materia,
                        Lectivo: element.lectivo,
                        Dia: element.dia,
                        Hora: element.hora
                    });
                });
            };

            /*$("#output").pivot(inputFunction, {
                rows: ["Plantel","Empleado"], 
                cols: ['Especialidad','Meta', 'Nivel', 'Grado'],
            });*/
            $("#output").pivotUI(inputFunction, {
                renderers: renderers,
                rows: ["Materia","Hora"], 
                cols: ['Dia'],
            },false, "es");

        });
        </script>

        

        <div id="output" style="margin: 30px;"></div>

    </body>
</html>
