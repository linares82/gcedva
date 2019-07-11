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
        table, #chart_div { margin: auto; font-family: Segoe UI; border: thin ridge gray; }*/
        th { font-size: 10px; background: #0046c3; color: #fff; max-width: 400px; padding: 2px 5px; }
        td { font-size: 10px; padding: 2px 10px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #fff; }
      
        </style>

    </head>
    <body>
        <div id="printeArea">
            <table>
                <tr><td><strong>Plantel:</strong>{{$inscripcion->plantel->razon}}</td><td><strong>Especialidad:</strong>{{$inscripcion->especialidad->name}}</td></tr>
                <tr><td><strong>Nivel:</strong>{{$inscripcion->nivel->name}}</td><td><strong>Grado:</strong>{{$inscripcion->grado->name}}</td></tr>
                <tr><td colspan='2'><strong>Alumno:</strong>{{$inscripcion->cliente->nombre}} {{$inscripcion->cliente->nombre2}} {{$inscripcion->cliente->ape_paterno}} {{$inscripcion->cliente->ape_materno}}</td></tr>
            </table>
            <table class="table table-condensed table-striped">
                    <thead style="">
                    <th>Lectivo</th><th>Grupo</th><th>Materia</th><th>Estatus</th><th>Calificaciones</th>
                    </thead>
                    <tbody>
                        @foreach($inscripcion->hacademicas as $a)
                        <tr>
                            <td>{{$a->lectivo->name}}</td><td>{{$a->grupo->name}}</td><td>{{$a->materia->name}}</td><td>{{$a->stMateria->name}}</td>
                            
                            <td colspan="2">
                                <table >
                                    <thead>
                                    <th>Evaluación</th><th>Calificación</th>
                                    </thead>
                                    <tbody>
                                        @foreach($a->calificaciones as $cali)
                                        <tr>
                                            <td>
                                                {{$cali->tpoExamen->name}}
                                            </td>
                                            <td>
                                                {{$cali->calificacion}}
                                            </td>
                                        <tr>
                                            @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
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

    </body>
</html>

