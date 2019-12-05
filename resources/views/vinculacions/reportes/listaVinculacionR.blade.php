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
            <h3>Lista de Alumnos en Vinculacion</h3>
            
            <table>
                <tr>
                    <th>No.</th><th><strong>Plantel</strong></th><th><strong>Alumno</strong></th>
                    <th><strong>Carrera</strong></th><th><strong>Estatus</strong></th><th><strong>Lugar Practica</strong></th>
                    <th><strong>F. Inicio</strong></th><th><strong>F. Fin</strong></th><th><strong>Folio</strong></th>
                </tr>
                @php
                    $i=1;
                @endphp
                @foreach($registros as $r)
                    <tr>
                    <td>{{$i++}}</td><td>{{$r->razon}}</td><td>{{$r->nombre}} {{$r->nombre2}} {{$r->ape_paterno}} {{$r->ape_materno}}</td>
                    <td>{{$r->especialidad}} {{$r->nivel}} {{$r->grado}}</td><td>{{$r->st_vinculacion}}</td><td>{{$r->lugar_practica}}</td>
                    <td>{{$r->fec_inicio}}</td><td>{{$r->fec_fin}}</td><td>{{$r->csc_vinculacion}}</td>
                    </tr>
                @endforeach
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

