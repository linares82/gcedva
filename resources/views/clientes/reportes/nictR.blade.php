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
        <h3>NICT</h3>

        

        <br>
        
        

        <br>

        <table class="table table-condensed table-striped">
          
          <thead>
              <th>No.</th><th>Plantel</th><th>Id</th><th>Matricula</th>
              <th>Nombre(s)</th><th>Apellidos</th><th>Seccion</th><th>Turno</th>
              <th>Inscripción/S. Escolares</th><th>Fecha Caja</th><th>P. Mensualidad</th><th>Fecha Pago</th>
              <th>Reclasificado</th><th>Tel. Celular</th><th>E. Cliente</th><th>E. Seguimiento</th>
              <th>Empleado</th><th>Trámites</th><th>Fecha Pago Tramites</th>
              
          </thead>
          <tbody>
            @php
             $i=0;   
             $cliente_temporal="";
            @endphp    
            @foreach($registros as $rs)
            @if($cliente_temporal<>$rs['matricula'])
            
            <tr>
              <td>{{ ++$i }}</td>
              
              <td>{{ $rs['razon'] }}</td><td>{{ $rs['cliente_id'] }}</td><td>{{ $rs['matricula'] }}</td>
              <td>{{ $rs['nombre'] }} {{ $rs['nombre2'] }}</td>
              <td>{{ $rs['ape_paterno'] }} {{ $rs['ape_materno'] }}</td>
              <td>{{ $rs['seccion'] }}</td><td>{{$rs['turno']}}</td>
              <td>{{$rs['12325']}}</td><td>{{ $rs['fecha_caja_12325'] }}</td>
              <td>{{$rs['primera_mensualidad']}}</td><td>{{$rs['primera_mensualidad_fecha']}}</td>
              <td>
              @if($rs['bnd_reclasificado']==1)
              Si
              @else
              No
              @endif
              </td>
              <td>{{$rs['tel_cel']}}</td><td>{{ $rs['st_cliente'] }}</td>
              <td>{{ $rs['st_seguimiento'] }}</td><td>{{ $rs['empleado_nombre'] }}</td>
              <td>{{$rs['tramites']}}</td><td>{{$rs['tramites_fecha']}}</td>
              
              
              
            </tr>
            @endif  
            @php
              $cliente_temporal=$rs['matricula'];
            @endphp
            @endforeach
          </tbody>
        </table>

        
        
    </div>
    
  </body>
</html>


