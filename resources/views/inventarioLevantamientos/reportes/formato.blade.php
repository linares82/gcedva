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
      
      
    <div class="datagrid">
        
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th ROWSPAN="2">No. Id.</th><th ROWSPAN="2">CANTIDAD</th><th ROWSPAN="2">NOMBRE</th><th ROWSPAN="2">MEDIDA</th><TH ROWSPAN="2">MARCA</TH>
                    <TH ROWSPAN="2">OBSERVACIONES</TH><TH COLspan="2">EXISTENCIA</TH><TH COLspan="2">ESTADO</TH>
                </tr> 
                <TR><TH>SI</TH><TH>NO</TH><TH>BUENO</TH><TH>MALO</TH></TR>
            </thead>    
                @php
                $ubicacion="";
                @endphp
                @foreach($table as $row)
                @if($ubicacion<>$row->ubicacion)
                <tr>
                    <th colspan="10" id="th_general">{{$row->escuela}}</th>
                </tr>
                <tr>
                    <th colspan="10" id="th_general">{{$row->tipo_inventario}}   -   {{$row->ubicacion}}</th>
                </tr>
                
                
                @endif
                <tr>
                    <td>{{$row->no_inventario}}</td><td>{{$row->cantidad}}</td><td>{{$row->nombre}}</td><td>{{$row->medida}}</td><td>{{$row->marca}}</td>
                    <td>{{$row->observaciones}}</td><td>{{$row->existencia_si}}</td><td>{{$row->existencia_no}}</td>
                    <td>{{$row->estado_bueno}}</td><td>{{$row->estado_malo}}</td>
                </tr>
                @php
                    $ubicacion=$row->ubicacion;
                @endphp
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

