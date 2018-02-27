<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Pivot Demo</title>
        
        <link rel="stylesheet" type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/base/jquery-ui.css" />
        <link rel="stylesheet" type="text/css" href="{{asset('bower_components/AdminLTE/plugins/jqplot/jquery.jqplot.min.css')}}" />

        <style>
            body {font-family: Verdana;}
            
            
        </style>


    </head>
    <body>
        <table id="barchart-table" class="data">
            <caption>Locating Element By Id</caption>
            <thead>
                <tr>
                    <th></th><th>Total</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($clientes as $c)
                <tr>
                    <th>{{$c->municipio}}</th><td>{{$c->cantidad}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div id="target">
        </div>        
        
        <div id="output" style="margin: 30px;"></div>
        <script src="{{ asset('bower_components/AdminLTE/plugins/jqplot/jquery-1.7.1.min.js') }}" type="text/javascript"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
        <script src="{{ asset('bower_components/AdminLTE/plugins/jqplot/excanvas.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bower_components/AdminLTE/plugins/jqplot/jquery.jqplot.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bower_components/AdminLTE/plugins/jqplot/plugins/jqplot.categoryAxisRenderer.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bower_components/AdminLTE/plugins/jqplot/plugins/jqplot.barRenderer.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bower_components/AdminLTE/plugins/jqplot/plugins/jqplot.pointLabels.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bower_components/AdminLTE/plugins/jqplot/jquery.tablechart.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bower_components/AdminLTE/plugins/jqplot/plugins/jqplot.barRenderer.js') }}" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#barchart-table').tablechart({
                  plotOptions: {
                    seriesDefaults: {
                      renderer: $.jqplot.BarRenderer,
                    },
                  }
                });
            });    
        </script>
    </body>
</html>
