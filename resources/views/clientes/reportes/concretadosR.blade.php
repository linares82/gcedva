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
        <h3>Concretados</h3>

        <table class="table table-condensed table-striped">
          
          <thead>
              <th>Plantel</th><th>Seccion</th><th>Estatus</th><th>Total</th>
          </thead>
          <tbody>
            @php
                $total_suma=0;
            @endphp
            @foreach($totales->toArray() as $total)
            <tr>
              @foreach($total as $celda)
              <td>{{ $celda }}</td>
              @endforeach
              @php
                  $total_suma=$total_suma+$total['total_estatus']
              @endphp
            </tr>  
            @endforeach
            <tr><td colspan="3">Total</td><td>{{ $total_suma }}</td></tr>
          </tbody>
        </table>

        <br>
        
        <table class="table table-condensed table-striped">
          
          <thead>
              <th>Plantel</th><th>Estatus</th><th>Total</th>
          </thead>
          <tbody>
            @php
                $total_suma=0;
            @endphp
            @foreach($totales2->toArray() as $total)
            <tr>
              @foreach($total as $celda)
              <td>{{ $celda }}</td>
              @endforeach
              @php
                  $total_suma=$total_suma+$total['total_estatus']
              @endphp
            </tr>  
            @endforeach
            <tr><td colspan="2">Total</td><td>{{ $total_suma }}</td></tr>
          </tbody>
        </table>

        <br>

        <table class="table table-condensed table-striped">
          
          <thead>
              <th>No.</th><th>Plantel</th><th>Matricula</th><th>Id</th><th>A. Paterno</th><th>A. Materno</th><th>P. Nombre</th>
              <th>S. Nombre</th><th>E. Cliente</th><th>E. Seguimiento</th><th>Seccion</th><th>Empleado</th>
              <th>Inscripción/S. Escolares</th><th>Fecha Pago</th><th>Trámites</th><th>Fecha Pago</th>
              <th>P. Mensualidad</th><th>Fecha Pago</th><th>Ultima Tarea Seguimiento</th><th>Doc. Oblig. Entregados</th><th>Documentos</th>
          </thead>
          <tbody>
            @php
             $i=0;   
            @endphp    
            @foreach($registros as $rs)
            <tr>
              <td>{{ ++$i }}</td>
              
              <td>{{ $rs['razon'] }}</td><td>{{ $rs['matricula'] }}</td><td>{{ $rs['cliente_id'] }}</td><td>{{ $rs['ape_paterno'] }}</td>
              <td>{{ $rs['ape_materno'] }}</td><td>{{ $rs['nombre'] }}</td><td>{{ $rs['nombre2'] }}</td><td>{{ $rs['st_cliente'] }}</td>
              <td>{{ $rs['st_seguimiento'] }}</td><td>{{ $rs['seccion'] }}</td><td>{{ $rs['empleado_nombre'] }}</td><td>{{ $rs['concepto'] }}</td>
              <td>{{ $rs['fecha_caja'] }}</td><td>{{$rs['tramites']}}</td><td>{{$rs['tramites_fecha']}}</td>
              <td>{{$rs['primera_mensualidad']}}</td><td>{{$rs['primera_mensualidad_fecha']}}</td>
              <td>
                @php
                    $tarea=App\AsignacionTarea::where('cliente_id',$rs['cliente_id'])
                    ->orderBy('id','desc')
                    ->whereNull('deleted_at')
                    ->first();
                @endphp
                @if(!is_null($tarea))
                  {{ $tarea->usu_alta->name }} ({{ $tarea->tarea->name }})
                @endif
              </td>
              <td>
                @if($rs['bnd_doc_oblig_entregados']==1)
                SI
                @else
                No
                @endif
              </td>
              
              <td>
                @php
                  $documentos=\App\PivotDocCliente::where('cliente_id', $rs['cliente_id'])
                  ->whereNotNull('archivo')
                  ->whereNull('deleted_at')
                  ->with('docAlumno')
                  ->get();
                  //dd($documentos->toArray());
                  $cliente=$rs['cliente_id'];
                @endphp
                @foreach($documentos as $documento)
                @php
                $cadena_img = explode('/', $documento->archivo);
                @endphp
                
                  <table>
                    <td>{{$documento->docAlumno->name}}</td>
                    <td>Entregado:{{$documento->docAlumno->name==1 ? 'SI' : 'NO'}}</td>
                    <td><a href="{{asset("imagenes/clientes/".$cliente."/".end($cadena_img))}}" target="_blank">Ver</a></td>
                    
                  </table>
                @endforeach
              </td>
              
              
            </tr>  
            @endforeach
          </tbody>
        </table>

        
        
    </div>
    
  </body>
</html>


