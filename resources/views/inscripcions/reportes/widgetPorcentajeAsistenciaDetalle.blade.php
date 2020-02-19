<html>
    <head>
        <style>
            @media print {
                table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 9px;
                }

                td, th {
                    border: 1px solid #dddddd;
                    text-align: left;
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
              h1, h3, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge gray; }
        th { font-size: 11px; background: #0046c3; color: #fff; max-width: 400px; padding: 2px 5px; }
        td { font-size: 10px; padding: 2px 10px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #fff; }
      
        </style>

    </head>
    <body>
        <div id="printeArea">
        <h3>Resumen de Asistencias de la semana anterior </h3>
            
            <table>
                <thead>
                    <th>Csc</th><th>Asignacion</th><th>Plantel</th><th>Instructor</th><th>Materia</th> <th>Grupo</th><th>Lectivo</th>
                    <th>Total Alumnos</th><th>Promedio Asistencia</th>
                </thead>
                @php
                    $cantidad_alumnos=0;
                    $suma_asistencia=0;
                    $indicador=0;
                    @endphp
                @foreach($resumen as $linea)
                    <tr>
                    <td>{{++$indicador}}</td>
                    <td>{{$linea['asignacion']}}</td><td>{{$linea['plantel']}}</td><td>{{$linea['instructor']}}</td>
                    <td>{{$linea['materia']}}</td><td>{{$linea['grupo']}}</td><td>{{$linea['lectivo']}}</td>
                    <td>{{$linea['total_alumnos']}}</td><td>{{round($linea['promedio_asistencia'],2)}}</td>
                    </tr>
                    @php
                    $suma_asistencia=$suma_asistencia+$linea['promedio_asistencia'];
                    $cantidad_alumnos=$cantidad_alumnos+$linea['total_alumnos'];
                    
                    @endphp

                @endforeach      
                <tr><td colspan="7"><strong>Total</strong></td><td><strong>{{$cantidad_alumnos}}</strong> </td><td><strong>{{round($suma_asistencia,2)}}</strong> </td></tr>  
                <tr><td colspan="7"><strong>Total</strong></td><td><strong>Promedio Gral.</strong> </td><td><strong>{{round($suma_asistencia/$indicador,2)}}</strong> </td></tr>
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

