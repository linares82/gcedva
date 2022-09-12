<html>
  <head>
      <link href="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.min.css')}}" rel="stylesheet" />
    
      <style>
        h1, h3, h5, th { text-align: center; font-family: Segoe UI; }
        table, #chart_div { margin: auto; font-family: Segoe UI; width: 100%; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        #th_general { font-size: 11px;background: #DFF10A; color: #000; max-width: 400px; padding: 5px 10px; }
        th { font-size: 11px;background: #BDBEB6; color: #000; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #fff; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    
  </head>
  <body>
      <h3>{{$plantel->razon}}</h3>
      <h3>{{$grupo->name}}</h3>
      
    <div class="datagrid">
        
        <table class="table table-condensed table-striped">
            <thead >
                <tr>
                    <th>No.</th><th>PLANTEL</th><th>ID</th><th>MATRICULA</th><th>ALUMNO</th><th>OPCION</th>
                    <th>MONTO</th><th>FECHA</th><th>OBSERVACIONES</th><th>Adeudo</th>
                </tr> 
            </thead>
            <tbody>
                @php
                $i=0;
                $monto_alumno=0;
                $cliente=0;
                @endphp
                @foreach($ingresos as $ingreso)
                <tr>
                    <td>{{++$i}}</td><td>{{$ingreso->razon}}</td><td>{{$ingreso->cliente_id}}</td><td>{{$ingreso->matricula}}</td>
                    <td>{{$ingreso->nombre}} {{$ingreso->nombre2}} {{$ingreso->ape_paterno}} {{$ingreso->ape_materno}}</td>
                    <td>{{$ingreso->opcion_titulacion}}</td><td>{{$ingreso->monto}}</td><td>{{$ingreso->fecha}}</td>
                    <td>{{$ingreso->observaciones}}</td>
                    @php
                        $monto_alumno=$monto_alumno+$ingreso->monto;
                        $cliente=$ingreso->cliente_id;
                    @endphp
                    <td>{{$ingreso->costo-$monto_alumno}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        

        
    </div>
    <div id="wdr-component"></div>  
    <script src="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.toolbar.min.js')}}"></script>
    <script src="{{asset('bower_components\AdminLTE\plugins\webdatarocks\webdatarocks.js')}}"></script>
    <script>
	
    </script>
  </body>
</html>

