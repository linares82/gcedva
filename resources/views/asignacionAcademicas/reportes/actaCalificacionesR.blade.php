<html>
    <head>
        <style>
            @media print {
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 10px;
                }

                td_izquierda {
                    border: 1px solid #dddddd;
                    text-align: right;
                    padding: 10px;
                }

                td_centro {
                    border: 1px solid #dddddd;
                    text-align: center;
                    padding: 10px;
                }

                tr:nth-child(even) {
                    background-color: #dddddd;
                }
            }
/* 
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
                font-size: 8px;
            }

            td th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            
            .altura {
                height: 100px;
            }
            
            .girar_texto {
                
                text-align: center;
                padding: 8px;
                transform: rotate(270deg);
                height: auto;
                
            }
            
            .centrar_texto {
                text-align: center;
                padding: 8px;
            }
            tr:nth-child(even) {
                background-color: #dddddd;
            }*/

            body{
                font-size: 11px;
                font-family: Segoe UI;
            }

              h1, h3, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; border: none ridge gray; }
        .table_calif { margin: auto; font-family: Segoe UI; border: thin ridge gray; }
        th { font-size: 10px; background: #0046c3; color: #fff; max-width: 400px; padding: 2px 5px; }
        td { font-size: 10px; padding: 2px 10px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #fff; }
      
        </style>

    </head>
    <body>
        <div id="printeArea">
            <table style="width:100%">
                <tr >
                    <td>
                        <img src="{{asset('storage/especialidads/'.$encabezado->especialidad->imagen)}}" alt="Logo" height="75" >

                    </td>
                    <td align="right" class="td_derecha">
                        {{ $encabezado->grado->denominacion }}<br/>
                        {{ $encabezado->grado->rvoe }}<br/>
                        @php
                            $fechaEntero=strtotime($encabezado->grado->fec_rvoe);
                            $anio=date('Y',$fechaEntero);
                            $mes=date('m',$fechaEntero);
                            $dia=date('d',$fechaEntero);
                            $mesLetra=\App\Mese::find($mes);
                            $calificacion=$encabezado->calificaciones->where('tpo_examen_id',1)->whereNotIn('deleted_at', NULL)->max()->id;
                            $actaFinal=\App\Calificacion::find($calificacion)->actaFinal;
                            //dd($actaFinal->toArray());
                        @endphp
                        RVOE S.E.P. NO {{ $encabezado->grado->rvoe }} de fecha {{ $dia }} de {{ $mesLetra->name }} de {{ $anio }}<br/>
                        {{ $encabezado->grado->cct }}
                        No. Acta: 
                        @permission("actaFinals.store")
                        @if(is_null($actaFinal))
                            <a class="btn btn-success" href="#" id="generarActa">Generar Acta</a>
                        @else
                            @php
                                $fecha=\Carbon\Carbon::createFromFormat('Y-m-d',$actaFinal->fecha);
                                    
                                echo "F".sprintf("%02d",$fecha->day).sprintf("%02d",$fecha->month).substr($fecha->year,-2).sprintf("%03d",$actaFinal->consecutivo);
                                    
                            @endphp

                        @endif
                        @endpermission
                    </td>
                    
                </tr>
            <tr ><td colspan='2' align="center" class="td_centro">ACTA DE CALIFICACIÓN VIA ORDINARIO {{ (is_numeric($numero) and !is_null($nomenclatura[$numero])) ? $nomenclatura[$numero] : "DEFINITIVA" }} </td></tr>
            </table>
            <br/>
            
            <table>
                <tbody>
                    <tr>
                        <td>Nombre de la Institución</td><td>{{ $encabezado->grado->denominacion }}</td><td>Fecha Emision</td><td>{{ Date('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <td>Nivel</td><td colspan='3'>{{ $encabezado->nivel->name }}</td>
                    </tr>
                    <tr>
                        <td>Programa</td><td colspan='3'>{{ $encabezado->grado->rvoe }}</td>
                    </tr>
                    <tr>
                        <td>Ciclo Escolar</td><td colspan='3'>{{ $encabezado->lectivo->name }}</td>
                    </tr>
                    <tr>
                        <td>Grupo</td><td colspan='3'>{{ $encabezado->grupo->name }}</td>
                    </tr>
                    <tr>
                        <td>Materia</td><td colspan='3'>{{ $encabezado->materia->name }}</td>
                    </tr>
                    <tr>
                        <td>Nombre del Docente</td><td><br/>{{ $asignacion_academica->docenteOficial->nombre }} {{ $asignacion_academica->docenteOficial->ape_paterno }} {{ $asignacion_academica->docenteOficial->ape_materno }}<br/><br/></td><td>Firma</td><td></td>
                    </tr>
                    
                </tbody>
            </table>
            
            <table class="table table-condensed table-striped table_calif">
                    <thead >
                    <th>No.</th><th>Matricula</th><th>Alumno</th><th>CURP</th><TH>Calificacion Número</TH><TH>Calificacion Letra</TH><th>T. Movimiento</th>
                    </thead>
                    <tbody>
                        @php
                            $i=0;
                            $calificacionesArray=array();
                        @endphp
                        @foreach($alumnos as $a)
                        <tr><td>{{ ++$i }}</td>
                            <td>{{optional($a->cliente)->matricula}}</td>
                            <td>{{ optional($a->cliente)->ape_paterno }} {{ $a->cliente->ape_materno }} {{ $a->cliente->nombre }} {{ $a->cliente->nombre2 }}</td>
                            <td>{{ $a->cliente->curp }}</td>
                            @php
                            //dd($datos);
                            if($datos['ponderacion_f']<>0){
                                $carga_ponderacion = App\CalificacionPonderacion::where('carga_ponderacion_id',$datos['ponderacion_f'])
                                ->where('calificacion_id',$a->calificaciones->max()->id)->first();
                                if(is_null($carga_ponderacion)){
                                    $promedio=0;    
                                }else{
                                    $promedio=$carga_ponderacion->calificacion_parcial;
                                }
                                
                                /*
                                $ponderaciones=App\CalificacionPonderacion::where('calificacion_id',$a->calificaciones->max()->id)
                                ->whereIn('carga_ponderacion_id',$array_ponderaciones)
                                ->get();
                                //dd ($ponderaciones->toArray());
                                //dd($ponderaciones->toArray());
                                $cantidad_calificaciones=0;
                                $suma_calificaciones=0;
                                foreach($ponderaciones as $p){
                                    $suma_calificaciones=$suma_calificaciones+$p->calificacion_parcial;
                                    $cantidad_calificaciones++;
                                }
                                //dd($cantidad_calificaciones);
                                if($cantidad_calificaciones>0){
                                    $promedio=$suma_calificaciones/$cantidad_calificaciones;
                                    //dd($promedio);
                                }else{
                                    $promedio=0;
                                    
                                }*/
                                
                            }elseif($datos['ponderacion_f']==0){
                                //$promedio=$a->calificaciones->max()->calificacion;
                                //dd($a->calificaciones->max());
                                $calificacion_id=$a->calificaciones->where('tpo_examen_id',1)->whereNotIn('deleted_at', NULL)->max()->id;
                                //dd($calificacion_id);
                                array_push($calificacionesArray, $calificacion_id);
                                $ponderaciones=App\CalificacionPonderacion::where('calificacion_id', $calificacion_id)
                                //->whereIn('carga_ponderacion_id',$array_ponderaciones)
                                ->get();
                                //dd($ponderaciones->toArray());
                                $cantidad_calificaciones=0;
                                $suma_calificaciones=0;
                                $calificacion_id=0;
                                foreach($ponderaciones as $p){
                                    $calificacion_id=$p->calificacion_id;
                                    $suma_calificaciones=$suma_calificaciones+$p->calificacion_parcial;
                                    $cantidad_calificaciones++;
                                }
                                //dd($cantidad_calificaciones);
                                if($cantidad_calificaciones>0){
                                    $promedio=$suma_calificaciones/$cantidad_calificaciones;
                                    //dd($promedio);
                                }else{
                                    $promedio=0;
                                    
                                }
                                if($calificacion_id<>0){
                                    $calificacion=\App\Calificacion::find($calificacion_id);
                                    $calificacion->calificacion=$promedio;
                                    Log::info($calificacion->id);
                                    $calificacion->save();
                                }
                                
                            }
                            
                            if($promedio>6){
                                $promedio=round($promedio,0);
                            }else{
                                $promedio=intdiv($promedio,1);
                            }
                            
                            @endphp
                            
                            <td> {{ $promedio }}</td><td>{{ $formatter->toWords($promedio,0) }}</td>
                            <td>
                                <input type="text" id="" name="TMovimiento" style="border: 0;width:25px;" value='A'>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                    </tr>

                    </tbody>
                </table>

        </div>

        <script type="text/php">
            /*if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            $pdf->page_text(670, 580, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }*/
        </script>

        <script src="{{ asset ('/bower_components/AdminLTE/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
    <script text="javascript">
        
        $(document).ready(function() {
            @if(isset($calificacionesArray))
            @php
            $idCalifiaciones="";
            @endphp
            @foreach($calificacionesArray as $idCalificacion)
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
                        'tipo_evaluacion':1, 
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

