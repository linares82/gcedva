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
                <h3>Registro de Docentes</h3>
            
            <table>
                <head>
                    <th>CURP</th><th>Primer Apellido</th><th>Segundo Apellido</th><th>Nombre</th><th>Fecha de nacimiento</th>
                    <th>Sexo</th><th>Estado de nacimiento</th><th>País de origen</th><th>Nivel académico</th>
                    <th>Nombre de la carrera</th><th>Cédula profesional</th><th>Fecha de inicio de experiencia académica</th>
                    <th>PROFORDEMS</th><th>Tipo de movimiento</th>
                </head>
                <body>
                    @foreach($registros as $r)
                    <tr>
                    <td>{{$r->curp}}</td><td>{{$r->ape_paterno}}</td><td>{{$r->ape_materno}}</td><td>{{$r->nombre}}</td>
                    <td>{{date_format(date_create($r->fec_nacimiento),'d-m-Y')}}</td>
                    <td>
                        @if($r->genero==1)
                        H
                        @else
                        M
                        @endif
                    </td>
                    <td>{{$r->estado_nacimiento}}</td><td>{{$r->pais_nacimiento}}</td><td>{{$r->nivel_estudio}}</td>
                    <td>{{$r->profesion}}</td><td>{{$r->cedula}}</td>
                    <td>
                        @if(!is_null($r->fec_inicio_experiencia_academicas))
                        {{date_format(date_create($r->fec_inicio_experiencia_academicas),'d-m-Y')}}
                        @endif
                        
                    </td>
                    <td>{{$r->profordems}}</td><td>A</td>
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

