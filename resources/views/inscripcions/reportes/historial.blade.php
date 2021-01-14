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

                        <img src="{{asset('storage/especialidads/'.$inscripcion->especialidad->imagen)}}" alt="Sin logo" height="80px" ></img>

                    </td>
                    <td align="right" class="td_derecha">
                        {{ $grado->denominacion }}<br/>
                        {{ $grado->name }}<br/>
                        @php
                            $fechaEntero=strtotime($grado->fec_rvoe);
                            $anio=date('Y',$fechaEntero);
                            $mes=date('m',$fechaEntero);
                            $dia=date('d',$fechaEntero);
                            $mesLetra=\App\Mese::find($mes);
                            @endphp
                        RVOE S.E.P. NO {{ $grado->rvoe }} de fecha {{ $dia }} de {{ $mesLetra->name }} de {{ $anio }}<br/>
                        
                    </td>
                    
                </tr>
                <tr ><td colspan='2' align="center" class="td_centro">HISTORIA ACADÉMICA</td></tr>
            </table>
            <p>
                Alumno: {{ $cliente->nombre }} {{ $cliente->nombre2 }} {{ $cliente->ape_paterno }} {{ $cliente->ape_materno }}<br/>
                Matricula: {{ $cliente->matricula }}
            </p>
            
            <table class="table table-condensed table-striped table_calif">
                    <thead >
                    <th>MATRICULA</th><th>ASIGNATURA</th><th>CLAVE</th><th>CRÉDITOS</th><th>PERIODO</th><th>CALIFICACION</th><TH>TIPO EVALUACION</TH>
                    </thead>
                    <tbody>
                        @php
                            $total_creditos=0;
                            $suma_calificaciones=0;
                            $total_materias=0;
                        @endphp
                        
                        @if($consulta_calificaciones->count())
                        @foreach($consulta_calificaciones as $a)
                        
                        <tr>
                            <td>{{ $cliente->matricula }}</td>
                            <td>{{$a->materia}}</td><td>{{$a->codigo}}</td><td>{{$a->creditos}}</td>
                            <td>{{$a->lectivo}}</td><td>{{$a->calificacion}}</td><td>{{$a->tipo_examen}}</td>
                            @php
                                $total_creditos=$total_creditos+$a->creditos;
                                $suma_calificaciones=$suma_calificaciones+$a['calificacion'];
                                $total_materias=$total_materias+1;
                            @endphp
                        </tr>
                        @endforeach
                        @endif
                        @foreach($hacademicas as $a)
                        
                        <tr>
                            <td>{{ $cliente->matricula }}</td>
                            <td>{{$a['materia']}}</td><td>{{$a['codigo']}}</td><td>{{$a['creditos']}}</td>
                            <td>{{$a['lectivo']}}</td><td>{{$a['calificacion']}}</td><td>{{$a['tipo_examen']}}</td>
                            @php
                                $total_creditos=$total_creditos+$a['creditos'];
                                $suma_calificaciones=$suma_calificaciones+$a['calificacion'];
                                $total_materias=$total_materias+1;
                            @endphp
                        </tr>
                        @endforeach
                        
                        <tr>
                            <td colspan="2" class="td_derecho">TOTAL DE CREDITOS</td><td>{{ $total_creditos }}</td>
                            <td colspan="2" rowspan='2' class="td_centro">PROMEDIO GENERAL</td><td rowspan='2'>{{ $total_materias==0 ? 0 : round(($suma_calificaciones/$total_materias),2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="td_derecho">%</td><td></td>
                        </tr>
                    </tbody>
                    </tr>

                    </tbody>
                </table>

                <div>
                    @php
                        $anio=date('Y');
                        $mes=date('m');
                        $dia=date('d');
                        $mesLetra=\App\Mese::find($mes);
                    @endphp
                    <table>
                        <tr>
                            <td class="td_centro" align="center">
                                {{ $plantel->estado }}, México; a {{ $dia }} de {{ $mesLetra->name }} de {{ $anio }} <br/><br/><br/>
                                {{ $plantel->director->nombre }} {{ $plantel->director->ape_paterno }} {{ $plantel->director->ape_materno }}
                                Director del Plantel
                            </td>
                        </tr>
                    </table>
                    
                </div>
        </div>

        <script type="text/php">
            /*if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            $pdf->page_text(670, 580, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }*/
        </script>

    </body>
</html>

