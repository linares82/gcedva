<html>
    <head>
        <style>
/*            @media print {
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
            <h3>Concentrado Parciales  </h3>

            <table>
                
                    <tr>
                        <th colspan='3'>
                        @foreach($materias as $materia)
                            <th colspan="{{ $materia->total_ponderaciones }}">{{ $materia->codigo }}</th>
                        @endforeach
                        
                    </tr>
                    
                
                @foreach($registros as $registro)
                
                <tr>
                    @if($loop->first)
                        <th>No.</th>
                        @foreach($registro as $celda)
                        <th>{{ $celda }}</th>
                        @endforeach
                        <th>Promedio Alumno</th>
                    @else
                        <td>{{ ++$no }}</td>
                        @foreach($registro as $celda)
                        <td>{{ $celda }}</td>
                        @if($loop->last)
                            @php
                             $promedio_grupal=$celda   
                            @endphp
                        @endif
                        @endforeach
                        
                    @endif
                </tr>
                
                @endforeach
                <tr>
                    <td></td><td></td><td>Promedio de la Materia</td>
                    @foreach($promedios as $promedio)
                        @if($loop->index>1)
                        <td>{{ $promedio }}</td>
                        @endif
                    @endforeach
                </tr>
                
            </table>

            <table>
                <thead>
                    <th>Promedio Grupal</th> <th>{{ $promedio_grupal }}</th>
                </thead>
            </table>

            <table>
                <thead><th>Materia</th><th>Clave</th></thead>
                <tbody>
                    @foreach($materias as $materia)
                    <tr>
                        <td>{{ $materia->materia }}</td><td>{{ $materia->codigo }}</td>
                    </tr>
                    @endforeach
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

    </body>
</html>

