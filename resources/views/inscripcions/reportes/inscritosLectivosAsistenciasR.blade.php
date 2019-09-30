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
      <h3>Inscritos <br/>Lectivo {{$lectivo->name}}</h3>
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th></th><th>Plantel</th><th>Especialidad</th><th>Grupo</th><th>Instructor</th><th>Materia</th><th>Cliente</th><th>Fecha Inscripción</th><th>Estatus Cliente</th><th>Asistencias Planeadas</th><th>Asistencias Registradas</th>
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
                        <td><strong>Suma Grupo</strong></td><td colspan="10"><strong>{{$i}}<strong></td>
                    </tr>
                    <?php 
                    $j=$i+$j;
                    $i=0;
                    ?>
                    @endif
                    
                    <tr>
                        <td>{{$contador_linea++}}</td>
                        <td>{{$plantel->razon}} </td>
                        <td>{{$registro->especialidad}}</td><td>{{$registro->grupo}} {{$registro->asignacion}}</td><td>{{$registro->instructor}}</td><td>{{$registro->materi}}</td> 
                        <td>{{$registro->id}} - {{$registro->cliente}}</td>
                        <td>{{$registro->fec_inscripcion}}</td>
                        <td>{{$registro->estatus_cliente}}</td>
                        <?php 
                        $asignacion = \App\AsignacionAcademica::find($registro->asignacion);
                        $dias = array();
                        //dd($asignacion);
                        foreach ($asignacion->horarios as $horario) {
                            array_push($dias, $horario->dia->name);
                        }
                        $fechas = array();
                        $lectivo = \App\Lectivo::find($data['lectivo_f']);
                        //dd($lectivo);
                        $no_habiles = array();
                        foreach ($lectivo->diasNoHabiles as $no_habil) {
                            array_push($no_habiles, \Carbon\Carbon::createFromFormat('Y-m-d', $no_habil->fecha));
                        }
                        $pinicio = \Carbon\Carbon::createFromFormat('Y-m-d', $data['fecha_f']);
                        $pfin = \Carbon\Carbon::createFromFormat('Y-m-d', $data['fecha_t']);
                        //dd($pfin->toDateString());
                        
                        $total_asistencias = 0;
                        while ($pfin->greaterThanOrEqualTo($pinicio)) {

                            if (in_array('Lunes', $dias)) {
                                //dd("hay lunes");
                                if ($pinicio->isMonday() and !in_array($pinicio, $no_habiles)) {
                                    array_push($fechas, $pinicio->toDateString());
                                    $total_asistencias++;
                                }
                                //dd($fechas);
                            }
                            if (in_array('Martes', $dias)) {
                                //dd("hay martes");
                                if ($pinicio->isTuesday() and !in_array($pinicio, $no_habiles)) {
                                    array_push($fechas, $pinicio->toDateString());
                                    $total_asistencias++;
                                }
                            }
                            if (in_array('Miercoles', $dias)) {
                                //dd("hay miercoles");
                                if ($pinicio->isWednesday() and !in_array($pinicio, $no_habiles)) {
                                    array_push($fechas, $pinicio->toDateString());
                                    $total_asistencias++;
                                }
                            }
                            if (in_array('Jueves', $dias)) {
                                //dd("hay jueves");
                                if ($pinicio->isThursday() and !in_array($pinicio, $no_habiles)) {
                                    array_push($fechas, $pinicio->toDateString());
                                    $total_asistencias++;
                                }
                            }
                            if (in_array('Viernes', $dias)) {
                                //dd("hay viernes");
                                if ($pinicio->isFriday() and !in_array($pinicio, $no_habiles)) {
                                    array_push($fechas, $pinicio->toDateString());
                                    $total_asistencias++;
                                }
                            }
                            if (in_array('Sabado', $dias)) {

                                if ($pinicio->isSaturday()  and !in_array($pinicio, $no_habiles)) {
                                    array_push($fechas, $pinicio->toDateString());
                                    $total_asistencias++;
                                }
                            }
                            $pinicio->addDay();
                            //dd($fechas);
                        }

                        $contador = 0;
                        foreach ($fechas as $fecha) {
                            $contador++;
                        }
                        ?>
                        <td>{{$contador}}</td>
                        <?php
                            $asistencias_registradas=0;
                            $fechas=\App\AsistenciaR::where('asignacion_academica_id',$asignacion->id)
                                            ->where('cliente_id',$registro->cliente_id)
                                            ->whereIn('fecha',$fechas)
                                            ->get();
                            foreach($fechas as $fecha){
                                $asistencias_registradas++;
                            }
                        ?>
                        <td>{{$asistencias_registradas}}</td>    
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
                        <td><strong>Suma Grupo</strong></td><td colspan="10"><strong>{{$i}}<strong></td>
                    </tr>
                    <tr>
                        <td><strong>Total</strong></td><td colspan="10"><strong>{{$j}}<strong></td>
                    </tr>
            </tbody>
        </table>
    </div>
    
  </body>
</html>

