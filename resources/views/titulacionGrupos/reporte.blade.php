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
                    <th colspan="3" id="th_general">OPERACIONES DE INGRESOS TITULACIÓN</th>
                </tr>
                <tr>
                    <th>CONCEPTO</th><th>ALUMNOS</th><th>INGRESO TOTAL DE ALUMNOS INSCRITOS</th>
                </tr> 
            </thead>
            <tbody>
            @php
                    $suma_ingresos=0;
                @endphp
                @foreach($ingresos as $ingreso)
                <tr>
                    <td>{{$ingreso['concepto']}}</td><td>{{$ingreso['total_alumnos']}}</td><td>{{number_format($ingreso['total_ingreso'], 2)}}</td>
                </tr>
                @php
                    $suma_ingresos=$suma_ingresos+$ingreso['total_ingreso'];
                @endphp
                @endforeach
                <tr>
                    <td colspan="2"><strong>TOTAL</strong></td><td>{{number_format($suma_ingresos,2)}}</td>
                </tr>
            </tbody>
        </table>
        <br>
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th colspan="6" id="th_general">OPERACIONES DE EGRESOS TITULACIÓN</th>
                </tr>
                <tr>
                    <th>CONCEPTO</th><th>NO. ALUMNOS</th> <th>CANTIDAD (Grupo, Equipo o Sinodal)</th>
                     <th>NO. HORAS</th> <th>C.U. (Hora, Equipo o Alumno)</th> <th>MONTO TOTAL</th>
                </tr> 
            </thead>
            <tbody>
            @php
                    $suma_egresos=0;
                @endphp
                @foreach($egresos as $egreso)
                <tr>
                    <td>{{$egreso->titulacionConcepto->name}}</td><td>{{$egreso->no_alumnos}}</td><td>{{$egreso->cantidad}}</td>
                    <td>{{$egreso->no_horas}}</td><td>{{$egreso->costo_unitario}}</td><td>{{number_format($egreso->monto_total,2)}}</td>
                </tr>
                @php
                    $suma_egresos=$suma_egresos+$egreso->monto_total;
                @endphp
                @endforeach
                <td colspan="5"><strong>TOTAL</strong></td><td>{{number_format($suma_egresos,2)}}</td>
            </tbody>
        </table>
        <br>
        <table class="table table-condensed table-striped">
            <thead >
                <tr>
                    <th colspan="2" id="th_general">RESUMEN DE INGRESOS Y EGRESOS DE TITULACION</th>
                </tr>
                <tr>
                    <th>CONCEPTO</th><th>MONTO TOTAL</th>
                </tr> 
            </thead>
            <tbody>
            
                <tr>
                    <td>INGRESO TOTAL DE ALUMNOS INSCRITOS</td><td>{{number_format($suma_ingresos,2)}}</td>
                </tr>
                <tr>
                    <td>MENOS TOTAL A PAGAR (DOCENTES, SCHOOLTECH Y SEP)</td><td>{{number_format($suma_egresos,2)}}</td>
                </tr>
                <tr>
                    <td>UTILIDAD</td><td>{{number_format($suma_ingresos-$suma_egresos,2)}}</td>
                </tr>
                <tr>
                    <td>PORCENTAJE DE UTILIDAD</td>
                    <td>{{number_format(($suma_ingresos-$suma_egresos)/$suma_ingresos,2)}} %</td>
                </tr>
            
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

