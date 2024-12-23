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
              <th>Plantel</th><th>Estatus</th><th>Total</th>
          </thead>
          <tbody>
            @php
                $total_suma=0;
            @endphp
            @foreach($totales_plantel_estatus as $total)
            <tr>
              <td>{{ $total['razon'] }}</td>
              <td>{{ $total['estatus'] }}</td>
              <td>{{ $total['total'] }}</td>
              @php
                $total_suma=$total_suma+$total['total']
              @endphp
            </tr>  
            @endforeach
            <tr><td colspan="2">Total</td><td>{{ $total_suma }}</td></tr>
          </tbody>
        </table>

        <br>
        
        <table class="table table-condensed table-striped">
          
          <thead>
              <th>Plantel</th><th>Seccion</th><th>Estatus</th><th>Total</th>
          </thead>
          <tbody>
            @php
                $total_suma=0;
            @endphp
            @foreach($totales_plantel_seccion_estatus as $total)
            <tr>
              <td>{{ $total['razon'] }}</td>
              <td>{{ $total['seccion'] }}</td>
              <td>{{ $total['estatus'] }}</td>
              <td>{{ $total['total'] }}</td>
              @php
                  $total_suma=$total_suma+$total['total']
              @endphp
            </tr>  
            @endforeach
            <tr><td colspan="3">Total</td><td>{{ $total_suma }}</td></tr>
          </tbody>
        </table>

        <br>

        <table class="table table-condensed table-striped">
          
          <thead>
              <th>No.</th><th>Plantel</th><th>Matricula</th><th>Id</th>
              <th>Nombre</th><th>Consulta CURP</th><th>Reclasificado</th><th>Tel. Celular</th><th>E. Cliente</th>  <th>E. Seguimiento</th><th>Seccion</th><th>Turno</th><th>Empleado</th>
              <th>Inscripción/S. Escolares</th><th>Fecha Caja</th><th>Trámites</th><th>Fecha Pago Tramites</th>
              <th>P. Mensualidad</th><th>Fecha Pago</th><th>Ultima Tarea Seguimiento</th><th>Doc. Oblig. Entregados</th><th>Documentos</th>
              <th>Prospecto/Creado Por</th>
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
              
              <td>{{ $rs['razon'] }}</td><td>{{ $rs['matricula'] }}</td><td>{{ $rs['cliente_id'] }}</td><td>{{ $rs['ape_paterno'] }}
              {{ $rs['ape_materno'] }} {{ $rs['nombre'] }} {{ $rs['nombre2'] }}</td>
              <td>
              @if($rs['bnd_consulta_curp']==1)
              Si
              @else
              No
              @endif  
              </td>
              <td>
              @if($rs['bnd_reclasificado']==1)
              Si
              @else
              No
              @endif
              </td>
              <td>{{$rs['tel_cel']}}</td><td>{{ $rs['st_cliente'] }}</td>
              <td>{{ $rs['st_seguimiento'] }}</td><td>{{ $rs['seccion'] }}</td><td>{{$rs['turno']}}</td><td>{{ $rs['empleado_nombre'] }}</td>
              <td>
                {{$rs['12325']}}
              </td>
              <td>{{ $rs['fecha_caja_12325'] }}</td><td>{{$rs['tramites']}}</td><td>{{$rs['tramites_fecha']}}</td>
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
          		{{$rs['bnd_doc_oblig_entregados']}}                
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
                    <td>Entregado:{{$documento->doc_entregado==1 ? 'SI' : 'NO'}}</td>
                    <td><a href="{{asset("imagenes/clientes/".$cliente."/".end($cadena_img))}}" target="_blank">Ver</a></td>
                  </table>
                @endforeach
              </td>
              <td>
                @php
                  $prospecto=App\Prospecto::where('cliente_id', $rs['cliente_id'])->first();
                @endphp
                @if(!is_null($prospecto))
                  {{$prospecto->id}} / {{$prospecto->usu_alta->name}}
                @endif
              </td>
              
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


