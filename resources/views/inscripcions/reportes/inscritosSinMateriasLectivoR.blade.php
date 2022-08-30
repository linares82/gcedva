<html>
  <head>
      <style>
        h1, h5, h3, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      </style>
    
  </head>
  <body>
      <h3>Inscritos</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th></th><th>Plantel</th><th>Especialidad</th><th>Nivel</th><th>Grado</th><th>Grupo</th>
                    <th>Turno</th><th>P. Estudio</th><th>Matricula</th>
                    <th>Cliente</th><th>P. Nombre</th><th>Celular</th><th>Fecha Inscripción</th>
                    <th>Estatus Cliente</th><th>Lectivo</th>
                </tr> 
            </thead>
            <tbody>
                <?php 
                $i=0; 
                $j=0;
                ?>
                <?php $grupo="" ?>
                <?php $contador_linea=1; ?>
                @foreach($registros as $registro)
                    @if($grupo<>$registro->grupo and $i<>0)
                    <tr>
                        <td><strong>Suma Grupo</strong></td><td colspan="15"><strong>{{$i}}<strong></td>
                    </tr>
                    <?php 
                    $j=$i+$j;
                    $i=0;
                    ?>
                    @endif
                    
                    <tr>
                        <td>{{$contador_linea++}}</td>
                        <td>{{$registro->plantel}} </td>
                        <td>{{$registro->especialidad}}</td><td>{{$registro->nivel}}</td><td>{{$registro->grado}}</td>
                        <td>{{$registro->grupo}} {{$registro->asignacion}}</td>
                        <td>{{ $registro->turno  }}</td><td>{{ $registro->periodo_estudio }}</td><td>{{ $registro->matricula }}</td>
                        <td>{{$registro->id}}</td><td>{{$registro->nombre}} {{$registro->nombre2}} {{$registro->ape_paterno}} {{$registro->ape_materno}}</td>
                        <td>{{$registro->tel_cel}}</td>
                        <td>{{$registro->fec_inscripcion}}</td>
                        <td>{{$registro->estatus_cliente}}</td>
                        <td>{{$registro->lectivo}}</td>    
                    </tr>
                    
                    <?php 
                    $grupo=$registro->grupo; 
                    $i++;
                    ?>
                @endforeach
                    <?php 
                    $j=$i+$j;
                    ?>
                    <tr>
                        <td><strong>Suma Grupo</strong></td><td colspan="8"><strong>{{$i}}<strong></td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td><td colspan="8"><strong>{{$j}}<strong></td>
                    </tr>
            </tbody>
        </table>
        <table>
            <thead>
                <th>Estatus</th><th>Cantidad</th>
            </thead>
            <tbody>
                @foreach($estatus_revisados as $estatus)
                @php
                    $cuenta=0;
                    foreach($registros as $registro){
                        if($registro->estatus_cliente==$estatus){
                            $cuenta++;
                        }
                    }
                    
                @endphp
                <tr>
                <td>{{$estatus}}</td><td>{{$cuenta}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
  </body>
</html>

