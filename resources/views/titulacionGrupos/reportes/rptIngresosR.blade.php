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
      <h3>Ingresos de titulacion</h3>
      
      
    <div class="datagrid">
        
        <table class="table table-condensed table-striped">
            <thead >
                <tr>
                    <th>No.</th><th>GRUPO</th><th>PLANTEL</th><th>ID</th><th>MATRICULA</th><th>ALUMNO</th><th>OPCION</th>
                    <th>MONTO</th><th>FECHA</th><th>OBSERVACIONES</th><th>Adeudo</th>
                </tr> 
            </thead>
            <tbody>
                @php
                $i=0;
                @endphp
                @foreach($ingresos as $ingreso)
                <tr>
                    <td>{{++$i}}</td><td>{{$ingreso->grupo}}</td><td>{{$ingreso->razon}}</td><td>{{$ingreso->cliente_id}}</td><td>{{$ingreso->matricula}}</td>
                    <td>{{$ingreso->nombre}} {{$ingreso->nombre2}} {{$ingreso->ape_paterno}} {{$ingreso->ape_materno}}</td>
                    <td>{{$ingreso->opcion_titulacion}}</td><td>{{$ingreso->monto}}</td><td>{{$ingreso->fecha}}</td>
                    <td>{{$ingreso->observaciones}}</td>
                    @php
                    $adeudo=App\Cliente::select('clientes.id as cliente_id','ot.costo', DB::raw('sum(tp.monto) as suma_pagos'))
                        ->join('titulacions as t', 't.cliente_id','clientes.id')
                        ->join('opcion_titulacions as ot','ot.id','t.opcion_titulacion_id')
                        ->join('titulacion_pagos as tp','tp.titulacion_id','t.id')
                        ->where('t.cliente_id', $ingreso->cliente_id)
                        ->where('t.titulacion_grupo_id', $ingreso->grupo_id)
                        ->whereNull('tp.deleted_at')
                        ->groupBy('clientes.id')
                        ->groupBy('ot.costo')
                        ->first();
                        
                    @endphp
                    <td>{{$adeudo->costo - $adeudo->suma_pagos}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        
        <p><h3>Adeudos</h3></p>

        <table class="table table-condensed table-striped">
            <thead >
                <tr>
                    <th>No.</th><th>GRUPO</th><th>PLANTEL</th><th>ID</th><th>MATRICULA</th><th>ALUMNO</th><th>OPCION</th>
                    <th>Adeudo</th>
                </tr> 
            </thead>
            <tbody>
                @php
                $i=0;
                @endphp
                @foreach($adeudos as $adeudo)
                <tr>
                    <td>{{++$i}}</td><td>{{$adeudo->grupo}}</td><td>{{$adeudo->razon}}</td><td>{{$adeudo->cliente_id}}</td><td>{{$adeudo->matricula}}</td>
                    <td>{{$adeudo->nombre}} {{$adeudo->nombre2}} {{$adeudo->ape_paterno}} {{$adeudo->ape_materno}}</td>
                    <td>{{$adeudo->opcion_titulacion}}</td>
                    <td>{{$adeudo->costo - $adeudo->suma_pagos}}</td>
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

