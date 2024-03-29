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
      <link href="{{ asset('/bower_components/AdminLTE/bootstrap/css/bootstrap.css') }}" rel="stylesheet" type="text/css" />    
      <link href="{{ asset('/bower_components/AdminLTE/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
      <link href="{{ asset('/bower_components/AdminLTE/dist/css/AdminLTE.min.css')}}" rel="stylesheet" type="text/css" />
  </head>
  <body>
    <div class="container">
        @if($datos['tipo_examen_f']==1)
    <h3>Evaluaciones Ordinarias</h3>
    @else
    <h3>Evaluaciones Extraordinarias</h3>
    @endif
    @permission("actaFinals.store")
    @if(isset($idCalificacionesArray) and $fecha_acta=="")
       <a class="btn btn-success" href="#" id="generarActa">Generar Acta</a>
    @endif
    @endpermission
    <div class="datagrid">
        <table class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th>Razón</th>
                    <th>RVOE</th><th>Ciclo Escolar</th><th>Subciclo Escolar</th><th>Tipo Evaluación</th>
                    @if($datos['tipo_examen_f']==1)
                            <th>Grupo</th>
                        @else
                            <th>Grado</th>
                        @endif
                    <th>CURP Docente</th><th>Clave Asignatura</th><th>Número Acta</th><th>Fecha Evaluación</th>
                    <th>CURP Alumno</th><th>ID</th><th>Calificacion</th>
                    <th>Tipo Movimiento</th>
                </tr> 
            </thead>
            <tbody>
                @foreach($registros as $registro)
                    <tr>
                        <td>{{ $registro->razon }}</td>
                        <td>{{$registro->rvoe}}</td><td>{{$registro->ciclo_escolar}}</td><td>{{$registro->periodo_escolar}}</td>
                        <td>@if($registro->tipo_examen=="Ordinario") 
                            ORD
                            @else
                            EE
                            @endif
                        </td>
                        @if($datos['tipo_examen_f']==1)
                            <td>{{$registro->grupo_numero."0".$registro->orden.$registro->grupo_letra}}</td>
                        @else
                            <td>{{$registro->grupo_numero}}</td>
                        @endif
                        <td>{{$registro->curp_docente}}</td><td>{{$registro->codigo}}</td>
                        <td>
                            @php
                                if(isset($idCalificacionesArray) and !is_null($registro->fecha_acta)){
                                    $fecha=\Carbon\Carbon::createFromFormat('Y-m-d',$registro->fecha_acta);
                                    if($datos['tipo_examen_f']==1){
                                        echo "F".sprintf("%02d",$fecha->day).sprintf("%02d",$fecha->month).substr($fecha->year,-2).sprintf("%03d",$registro->consecutivo_acta);
                                    }else{
                                        $fecha_extra=$fecha->addDay(3);
                                        echo "E".sprintf("%02d",$fecha_extra->day).sprintf("%02d",$fecha_extra->month).substr($fecha_extra->year,-2).sprintf("%03d",$registro->consecutivo_acta);
                                    }
                                    
                                }
                                $fecha_evaluacion=\Carbon\Carbon::createFromFormat('Y-m-d',$registro->fin);
                                
                            @endphp
                            
                        </td><td>{{ $fecha_evaluacion->format('d-m-Y') }}</td>
                        <td>{{$registro->curp}}</td><td>{{ $registro->cliente }}</td>
                        <td>@if($registro->calificacion<6)
                            {{ 5 }}
                            @else
                            {{ round($registro->calificacion) }}
                            @endif
                        </td><td>A</td>
                    </tr>
                    
                @endforeach
                    
            </tbody>
        </table>
    </div>
    </div>
    
    <script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script text="javascript">
        
        $(document).ready(function() {
            @if(isset($idCalificacionesArray))
            @php
            $idCalifiaciones="";
            @endphp
            @foreach($idCalificacionesArray as $idCalificacion)
                @if($loop->first)
                    @php $idCalifiaciones=$idCalificacion; @endphp
                @else
                    @php $idCalifiaciones=$idCalifiaciones.",".$idCalificacion; @endphp
                @endif
            @endforeach
                
             $('#generarActa').click(function(){ 
                $.ajax({
                    url: '{{ route("actaFinals.store") }}',
                    type: 'GET',
                    data: { 
                        'plantel':{{ $datos['plantel_f'] }},
                        'lectivo':{{ $datos['lectivo_f'] }}, 
                        'tipo_evaluacion':{{ $datos['tipo_examen_f'] }}, 
                        'calificaciones':'{{ $idCalifiaciones }}' 
                    },
                    //dataType: 'json',
                    beforeSend : function(){$("#loading10").show(); },
                    complete : function(){$("#loading10").hide(); },
                    success: function(data){
                        location.reload();
                        //console.log('Termine');
                    }
                    });
            });
        @endif    
        });
        
    </script>    
  </body>
</html>

