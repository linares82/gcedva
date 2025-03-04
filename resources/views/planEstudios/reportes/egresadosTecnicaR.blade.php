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

                td, th {
                    border: 1px solid #dddddd;
                    text-align: center;
                    padding: 10px;
                }

                tr:nth-child(even) { background: #dae5f4; }
                tr:nth-child(odd) { background: #fff; }
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
        .SaltoDePagina
         {
          page-break-after: always;
          width:1200px;
          padding:10px;

         }
         
        .verticalText {
            writing-mode: vertical-lr;
            transform: rotate(90deg);
        } 
         
         body{
             font-family: arial, sans-serif;
         }
        h1, h3, h5, th { text-align: center; }
       
        th { font-size: 10px; max-width: 400px; padding: 2px 5px; border: 1px solid #dddddd;}
        td { font-size: 10px; padding: 2px 10px; color: #000; border: 1px solid #dddddd;}
        tr { background: #b8d1f3; border: 1px solid #dddddd;}
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #fff; }
      
        </style>

    </head>
    <body>
        
        <div id="printeArea" class='SaltoDePagina'>
                <h3>Egresados de Tecnica</h3>
            
            <table>
                <head>
                    <th>No.</th><th>Matricula</th><th colspan="2" >Nombre</th>
                    @foreach($materias as $materia)
                    <th>{{$materia->materia}}</th>
                    @endforeach
                    <th>Promedio</th>
                    <th>Estatus</th>
                </head>
                <body>
                    @php
                        $i=0;
                    @endphp
                    @foreach($resultados as $r)
                    <tr>
                    <td>{{++$i}}</td><td>{{$r['matricula']}}</td><td>{{$r['nombre']}}</td><td>{{$r['apellidos']}}</td>
                    @foreach ($materias as $materia)
                        <td>{{$r[$materia->materia]}}</td> 
                    @endforeach
                    <td>
                        @if(is_numeric($r['promedio']))
                        {{ round($r['promedio'],2)}} 
                        @else
                            {{$r['promedio']}}
                        @endif
                    </td>
                    <td>{{$r['st_cliente']}}</td>
                    </tr>
                @endforeach    
                </body>
                
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

