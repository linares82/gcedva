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
                    <tr>
                        <td>{{$registro->grado->rvoe}}</td><td>{{$registro->lectivo->ciclo_escolar}}</td>
                        <td>{{$registro->lectivo->periodo_escolar}}</td><td></td><td>{{$registro->cliente->curp}}</td>
                        <td>{{ $registro->cliente->matricula }}</td><td>{{ $registro->lectivo->inicio }}</td>
                        <td>{{ $registro->stInscripcion->name }}</td><td>{{ $registro->cliente->ape_paterno }}</td>
                        <td>{{ $registro->cliente->ape_materno }}</td><td>{{ $registro->cliente->nombre }} {{ $registro->cliente->nombre2 }}</td>
                        <td>{{ $registro->cliente->fec_nacimiento }}</td>
                        <td>
                            @if($registro->cliente->genero==1)
                            H
                            @else
                            M
                            @endif
                        </td>
                        <td>
                            @if(strlen($registro->cliente->estadoNacimiento->id)==1)
                            0{{ $registro->cliente->estadoNacimiento->id }}
                            @else
                            {{ $registro->cliente->estadoNacimiento->id }}
                            @endif
                        </td>
                        <td>
                            @if($registro->cliente->bnd_trabaja==1)
                            S
                            @else
                            N
                            @endif
                        </td>
                        <td>
                            @if($registro->cliente->bnd_indigena==1)
                            S
                            @else
                            N
                            @endif
                            </td><td>{{ optional($registro->cliente->discapacidad)->clave }}</td>
                        <td>
                            @if(optional($registro)->st_beca_id==4)
                            S 
                            @else
                            N
                            @endif
                        </td>
                        <td>
                            {{ optional($registro)->tipo_beca_id ? optional($registro)->tipo_beca_id : 0 }}
                        </td>
                        <td>2</td>
                        <td>{{ optional($registro)->monto_mensualidad ? optional($registro)->monto_mensualidad : 0 }}</td>
                        <td>{{ optional($registro)->monto_mensualidad ? (optional($registro)->monto_mensualidad * optional($registro)->mensualidad_sep) : "" }}</td>
                        <td>A</td>
                    </tr>
                    
                @endforeach
                    
            </tbody>
        </table>
    </div>
    
  </body>
</html>

