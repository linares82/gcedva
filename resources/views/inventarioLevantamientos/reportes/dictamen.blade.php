<html>
  <head>
      <link href="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.min.css')}}" rel="stylesheet" />
    
      <style>
        @media print {
            h1, h3, h5, th { text-align: center; font-family: Segoe UI; }
            table, #chart_div { margin: auto; font-family: Segoe UI; width: 100%; box-shadow: 10px 10px 5px #888; border: 1px solid; border-collapse: collapse;}
            #th_general { font-size: 11px;background: #E3E3DD; color: #000; max-width: 400px; padding: 5px 10px; }
            th { font-size: 11px;background: #E3E3DD; color: #000; max-width: 400px; padding: 5px 10px; border: 1px solid black; border-collapse: collapse;}
            td { font-size: 11px; padding: 10px 20px; color: #000; border: 1px solid black; }
            tr { background: #fff; }
            tr:nth-child(even) { background: #D0EEF9; }
            tr:nth-child(odd) { background: #fff; }        
            @page
            {
                size: auto; /* auto is the initial value */
                margin: 2mm 4mm 0mm 0mm; /* this affects the margin in the printer settings */
            }
            thead
            {
                display: table-header-group;
            }
            tfoot
            {
                display: table-footer-group;
            }
        }

        h1, h3, h5, th { text-align: center; font-family: Segoe UI; }
        table, #chart_div { margin: auto; font-family: Segoe UI; width: 100%; box-shadow: 10px 10px 5px #888; border: 1px solid; border-collapse: collapse;}
        #th_general { font-size: 11px;background: #E3E3DD; color: #000; max-width: 400px; padding: 5px 10px; }
        th { font-size: 11px;background: #E3E3DD; color: #000; max-width: 400px; padding: 5px 10px; border: 1px solid black; border-collapse: collapse;}
        td { font-size: 11px; padding: 5px 20px; color: #000; border: 1px solid black; }
        tr { background: #fff; }
        tr:nth-child(even) { background: #D0EEF9; }
        tr:nth-child(odd) { background: #fff; }
      </style>
    
  </head>
  <body>
      <h3>{{$plantel->razon}}</h3>
      <h3>{{$inventarioLevantamiento->fecha}}</h3>
      
    <div class="datagrid">
        
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Plantel</th><th>Observacion</th><th>Autor</th>
                </tr> 
            </thead>               
                @foreach($inventarioObservaciones as $obs)
                <tr>
                    <td>{{$obs->plantelInventario->name}}</td><td>{{$obs->observacion}}</td><td>{{$obs->usu_alta->name}}</td>
                </tr>
                @endforeach
        </table>
        <br>
        

        
    </div>
    <div id="wdr-component"></div>  
    <script src="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.toolbar.min.js')}}"></script>
    <script src="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.js')}}"></script>
    <script>
	
    </script>
  </body>
</html>

