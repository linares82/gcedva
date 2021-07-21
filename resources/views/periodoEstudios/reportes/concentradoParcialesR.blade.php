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
            
            @foreach($resultado as $registros)
            <table>
            @php
            //dd($registros);
            $no=0;
            $promedio_grupal=0;

            $materias=array();
            $contador_alumnos=0;
            @endphp
            
            @php
                $suma_calificaciones = array();
                $cantidad = array();
                $promedios = array();
                $i = 0;
                
                foreach ($registros as $registro) {
                    $j = 0;
                    //dd($registro);
                    if($i>1){
                       //dd($registro); 
                       foreach ($registro as $celda) {
                            //dd($registro);
                            //dd($celda);
                            //if(!is_string($celda)){
                            if($j>2){

                                //dd($celda);
                                if(!array_key_exists($j, $suma_calificaciones)){
                                    $suma_calificaciones[$j]=0;    
                                }
                                $suma_calificaciones[$j] = $suma_calificaciones[$j] + floatval($celda);    
                                if(!array_key_exists($j, $cantidad)){
                                    $cantidad[$j]=0;    
                                }
                                $cantidad[$j]++;
                                
                            }
                            $j++;
                        }
                        //dd($suma_calificaciones);
                    }
                    $i++;
                }
                //dd($cantidad);
                $i = 3;
                
                foreach ($suma_calificaciones as $suma) {
                    
                    $promedios[$i] = round($suma / $cantidad[$i], 1);
                    $i++;
                }
            @endphp
            
        
            @foreach($registros as $registro)
                
                @if($loop->index==0)
                    @php
                    $cantidad_celdas=count($registro);    
                    $i=1;
                    @endphp
                    
                        <tr>
                            <th colspan=""></th><th colspan=""></th><th colspan=""></th><th colspan=""></th>
                            @while($i<($cantidad_celdas-2))
                                <th colspan="{{ $registro[$i+2] }}">{{$registro[$i]}}</th>
                                @php
                                    array_push($materias, array('codigo'=>$registro[$i], 'materia'=>$registro[$i+1]));
                                    $i++; $i++; $i++;
                                @endphp
                            @endwhile
                            <th></th>
                        </tr>
                    
                @elseif($loop->index==1)
                    <th colspan="">No.</th>
                    @foreach($registro as $celda)
                        <th>{{ $celda }}</th>
                    @endforeach
                    <th>Promedio Alumno</th>
                @else
                    <tr>
                        <td>{{ ++$no }}</td>
                        @foreach($registro as $celda)
                        <td>{{ $celda }}</td>
                        @if($loop->last)
                            @php
                             $promedio_grupal=$promedio_grupal+$celda;
                             $contador_alumnos++;   
                            @endphp
                        @endif
                        @endforeach
                    </tr>
                @endif
            @endforeach
            <tr>
                <td></td><td></td><td></td><td>Promedio de la Materia</td>
                @foreach($promedios as $promedio)
                <td>{{ $promedio }}</td>
                @endforeach
            </tr>
            </table>
            <br/>
            
            <table>
                <thead>
                    <th>Promedio Grupal</th> 
                    <th>
                        @if($contador_alumnos>0)
                        {{ round($promedio_grupal/$contador_alumnos, 2) }}
                        @else
                        0
                        @endif
                    </th>
                </thead>
            </table>
            <br/>
            
            <table>
                <thead><th>Materia</th><th>Clave</th></thead>
                <tbody>
                    @foreach($materias as $materia)
                    <tr>
                        <td>{{ $materia['materia'] }}</td><td>{{ $materia['codigo'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <br/>
            <br/>
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

