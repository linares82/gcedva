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
                        {{ $encabezado->grado->name }}<br/>
                        @php
                            $fechaEntero=strtotime($encabezado->grado->fec_rvoe);
                            $anio=date('Y',$fechaEntero);
                            $mes=date('m',$fechaEntero);
                            $dia=date('d',$fechaEntero);
                            $mesLetra=\App\Mese::find($mes);
                            @endphp
                        RVOE S.E.P. NO {{ $encabezado->grado->rvoe }} de fecha {{ $dia }} de {{ $mesLetra->name }} de {{ $anio }}<br/>
                        {{ $encabezado->grado->cct }}
                    </td>
                    
                </tr>
            <tr ><td colspan='2' align="center" class="td_centro">ACTA DE EXÁMENES ORDINARIA </td></tr>
            </table>
            <br/>
            
            <table>
                <tbody>
                    <tr>
                        <td>Asignatura</td><td colspan='3'>{{ $hacademica->materia->name }}</td>
                        <td>F. de Extraordinario</td><td colspan='3'></td>
                    </tr>
                    <tr>
                        <td>Clave de Asignatura</td><td colspan='3'>{{ $hacademica->materia->codigo }}</td>
                        <td>Grupo</td><td colspan='3'>{{ $hacademica->grupo->name }}</td>
                    </tr>
                    <tr>
                        <td>Periodo</td><td colspan='3'>{{ $hacademica->lectivo->ciclo_escolar }}</td>
                        <td>Ciclo Escolar</td><td colspan='3'>{{ $hacademica->lectivo->ciclo_escolar }}</td>
                    </tr>
                    
                </tbody>
            </table>
            
            <table class="table table-condensed table-striped table_calif">
                    <thead >
                    <th>No.</th><th>Matricula</th><th>Alumno</th><th>CURP</th><TH>Calificacion</TH><TH>Ciclo</TH>
                    </thead>
                    <tbody>
                        @php
                            $i=0;
                        @endphp
                        @foreach($calificaciones as $c)
                        <tr><td>{{ ++$i }}</td>
                            <td>{{$c->cliente->matricula}}</td>
                            <td>{{ $c->cliente->ape_paterno }} {{ $c->cliente->ape_materno }} {{ $c->cliente->nombre }} {{ $c->cliente->nombre2 }}</td>
                            <td>{{ $c->cliente->curp }}</td>
                            
                            <td>{{ $c->calificacion }}</td><td>{{ $c->lectivo->name }}</td>
                            
                        </tr>
                        @endforeach
                        
                    </tbody>
                    </tr>

                    </tbody>
                </table>

            <table>
                <br><br><br><br><br><br>
            <tr style="width: 100%;">
                <td>
                    Nombre y Firma del Docente
                </td>
                <td>
                    _______________________________________________________
                    
                </td>
            </tr>
            </table>    
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
