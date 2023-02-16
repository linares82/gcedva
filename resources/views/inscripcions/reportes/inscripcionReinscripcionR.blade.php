<html>
  <head>
      <style>
        h1, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    
  </head>
  <body>
      <h3>Inscripcion Reinscripcion</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>RVOE</th><th>Ciclo Escolar</th><th>Periodo Escolar</th><th>Clave Mapa Curricular Alumno</th>
                    <th>CURP Alumno</th><th>Matricula</th><th>Fecha Inscripcion</th><th>Tipo Inscripción</th>
                    <th>Primer Apellido</th><th>Segundo Apellido</th><th>Nombre</th><th>Fecha Nacimiento</th>
                    <th>Sexo</th><th>Estado Nacimiento</th><th>Trabaja</th><th>Grupo Indígena</th><th>Discapacidad</th>
                    <th>Becado</th><th>Tipo Beca</th><th>Concepto Excentar</th><th>% Beca</th><th>Monto Beca</th>
                    <th>T. Movimiento</th>
                </tr> 
            </thead>
            <tbody>
                @foreach($registros as $registro)
                    @php
                        $beca=\App\AutorizacionBeca::where('cliente_id',$registro->cliente_id)
                        ->where('lectivo_id',$registro->lectivo_id)
                        ->where('st_beca_id',4)
                        ->first();                        
                        //if(isset($beca)) dd($beca);
                    @endphp
                    <tr>
                        <td>{{$registro->rvoe}}</td><td>{{$registro->ciclo_escolar}}</td>
                        <td>{{$registro->periodo_escolar}}</td><td>{{ $registro->id_mapa }}</td><td>{{$registro->curp}}</td>
                        <td> {{ $registro->mesAnioMatricula.sprintf("%03d", $registro->plantel_id).sprintf("%07d", $registro->cliente_id)  }}</td><td>{{ $registro->inicio }}</td>
                        <td>{{ $registro->st_inscripcion_id }}</td><td>{{ $registro->cliente->ape_paterno }}</td>
                        <td>{{ $registro->ape_materno }}</td><td>{{ $registro->nombre }} {{ $registro->nombre2 }}</td>
                        <td>{{ $registro->fec_nacimiento }}</td>
                        <td>
                            @if($registro->genero==1)
                            H
                            @else
                            M
                            @endif
                        </td>
                        <td>
                            @if($registro->estado_nacimiento_id<10)
                            0{{ $registro->estado_nacimiento_id }}
                            @else
                            {{ $registro->estado_nacimiento_id }}
                            @endif
                        </td>
                        <td>
                            @if($registro->bnd_trabaja==1)
                            S
                            @else
                            N
                            @endif
                        </td>
                        <td>
                            @if($registro->bnd_indigena==1)
                            S
                            @else
                            N
                            @endif
                        </td><td>{{ $registro->discapacidad_clave }}</td>
                        <td>
                            @if(!is_null($beca))
                            @if($beca->tipo_beca_id==0)
                            N
                            @else
                            S
                            @endif
                            @endif
                        </td>
                        <td>
                            {{ !is_null($beca) ? $beca->tipo_beca_id : 0 }}
                        </td>
                        <td>{{ !is_null($beca) ? $beca->tipo_beca_id : 0 }}</td>
                        <td>{{ !is_null($beca) ? $beca->monto_mensualidad : 0 }}</td>
                        <td>{{ !is_null($beca) ? ($beca->monto_mensualidad * $beca->mensualidad_sep) : "" }}</td>
                        <td>A</td>
                    </tr>
                    
                @endforeach
                    
            </tbody>
        </table>
    </div>
    
  </body>
</html>

