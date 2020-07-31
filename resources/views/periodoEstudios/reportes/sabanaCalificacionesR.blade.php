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
            <h3>Sabana de Calificaciones  </h3>

            <table>
                <thead>
                    <tr>
                        <th colspan='3'>
                        @foreach($periodos as $periodo)
                            <th colspan="{{ $periodo->cantidad_materias }}">{{ $periodo->periodo }}</th>
                        @endforeach
                    </tr>
                    
                </thead>
                @foreach($registros as $registro)
                <tr>
                    @if($loop->first)
                        <th>No.</th>
                        @foreach($registro as $celda)
                        <th>{{ $celda }}</th>
                        @endforeach
                    
                    @else
                        <td>{{ ++$no }}</td>
                        @foreach($registro as $celda)
                        <td>{{ $celda }}</td>
                        @endforeach
                    @endif
                </tr>
                @endforeach
            </table>

            

            @foreach($periodos as $periodo)
            <div style="float: left;">
                <table>
                    <thead><th colspan="2">{{ $periodo->periodo }}</th></thead>
                    <tbody>
                        <tr><td>Materia</td><td>Clave</td></tr>
                        
                        @php
                        $consulta_periodos=\App\PeriodoEstudio::find($periodo->id);
                        //dd($materias);
                        @endphp
    
                        @foreach($consulta_periodos->materias as $materia)
                        <tr>
                            <td>{{ $materia->name }}</td>
                            <td>{{ $materia->codigo }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach

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

