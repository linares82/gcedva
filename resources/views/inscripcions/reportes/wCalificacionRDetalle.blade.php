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
        <h3>Resumen de Calificaciones de {{$mese->name}}</h3>
            
            <table>
                <thead>
                    <th>Especialidad</th><th>Nivel</th><th>Grado</th><th>Grupo</th> <th>Cantidad Alumnos</th><th>Promedio</th>
                </thead>
                @php
                    $cantidad_alumnos=0;
                    $suma_cali=0;
                    $cantidad_alumnos_gr=0;
                    $suma_cali_gr=0;
                    $grado=0;
                    $indicador=0;
                    @endphp
                @foreach($resumen as $linea)
                    @if($grado<>$linea['grado'] and $indicador<>0)
                    <tr><td colspan="4"><strong>Total</strong></td><td><strong>{{$cantidad_alumnos_gr}}</strong> </td><td><strong>{{round($suma_cali_gr/$cantidad_alumnos_gr,2)}}</strong> </td></tr>
                    @php
                        $cantidad_alumnos_gr=0;
                        $suma_cali_gr=0;
                    @endphp
                    @endif
                    <tr>
                    <td>{{$linea['especialidad']}}</td><td>{{$linea['nivel']}}</td><td>{{$linea['grado']}}</td>
                    <td>{{$linea['grupo']}}</td>
                    <td>{{$linea['cantidad']}}</td><td>{{round($linea['promedio'],2)}}</td>
                    </tr>
                    @php
                    $suma_cali=$suma_cali+$linea['calificacion'];
                    $cantidad_alumnos=$cantidad_alumnos+$linea['cantidad'];
                    $grado=$linea['grado'];
                    $cantidad_alumnos_gr=$cantidad_alumnos_gr+$linea['cantidad'];
                    $suma_cali_gr=$suma_cali_gr+$linea['calificacion'];
                    $indicador++;
                    @endphp

                @endforeach      
                <tr><td colspan="4"><strong>Total</strong></td><td><strong>{{$cantidad_alumnos_gr}}</strong> </td><td><strong>{{round($suma_cali_gr/$cantidad_alumnos_gr,2)}}</strong> </td></tr>  
                <tr><td colspan="4"><strong>Total</strong></td><td><strong>{{$cantidad_alumnos}}</strong> </td><td><strong>{{round($suma_cali/$cantidad_alumnos,2)}}</strong> </td></tr>
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

