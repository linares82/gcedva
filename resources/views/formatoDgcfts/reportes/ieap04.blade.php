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

         table {
                    font-family: arial, sans-serif;
                    border-collapse: collapse;
                    width: 100%;
                    font-size: 10px;
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
            <table width="100%">
                <tr>
                    <th><img src="{{asset('images/sep.jpg')}}" alt='logo_sep' width="250px;"></img></th>
                    <th align='center'>
                        DIRECCIÓN GENERAL DE CENTROS DE FORMACIÓN PARA EL TRABAJO <br/>
                        DIRECCIÓN TÉCNICA <br/>
                        SUBDIRECCIÓN DE VINCULACIÓN Y APOYO ACADÉMICO <br/>
                        INFORME ESTADÍSTICO DE INSCRIPCIÓN Y ACREDITACIÓN (IEAP-04)<br/>
                    </th>
                </tr>
            </table>
            <br/>
            <table width="100%">
                <tr>
                    <td>ENLACE OPERATIVO:<strong>{{$formatoDgcft->plantelR->enlace}}</strong></td>
                    <td colspan="2">PLANTEL PARTICULAR: <strong>{{$formatoDgcft->plantelR->denominacion}}</strong></td>
                    <td>CLAVE CCT: {{$formatoDgcft->plantelR->cct}} </td>
                </tr>
                <tr>
                    <td colspan="2">UBICACION:
                        <strong>
                            {{$formatoDgcft->plantelR->calle}} {{$formatoDgcft->plantelR->no_int}}, 
                            Col. {{$formatoDgcft->plantelR->colonia}}, {{$formatoDgcft->plantelR->municipio}}, 
                            {{$formatoDgcft->plantelR->estado}}, C.P. {{$formatoDgcft->plantelR->cp}}
                        </strong>
                    </td>
                    <td>FECHA ELABORACION: {{explode(',',$formatoDgcft->fechas_emision)[0]}} </td>
                    <td>CICLO ESCOLAR:{{$formatoDgcft->ciclo_escolar}}</td>
                </tr>
                
            </table>
            <br/>
            <table width="100%">
                <thead>
                <tr>
                    <th colspan="9" width="70%"></th><th colspan="7" width="30%">ACREDITACION</th>
                </tr>
                <tr>
                    <th rowspan="2" >GRADO</th><th rowspan="2">GRUPO</th>
                    <th rowspan="2">NOMBRE DE LA MATERIA/MODULO</th><th COLSPAN="2">FECHA</th>
                    <th COLSPAN="2">HORARIO</th><th rowspan="2">DURACION HORAS</th>
                    <th ROWspan="2"> INSCRITOS</th><th ROWspan="2"> ACREDITADOS</th><th ROWSPAN="2">BAJAS</th>
                    <th COLSPAN="2">DOCUMENTOS</th>
                </tr>
                    
                <tr>
                <TH>INICIO</TH><TH>TERMINO</TH><TH>DE</TH><TH>A</TH><TH>I</TH><TH>D</TH>
                </tr>
                </thead>
                <tbody>
                    @php
                        $cantidad_materias=count($materias);
                        $contador=0;
                        $grados=explode(',',$formatoDgcft->grados);
                        $duracion_materias=explode(',',$formatoDgcft->duracion_materias);
                    @endphp
                    @foreach ($materias as $materia)
                        <tr>
                            <td>{{$grados[$loop->index]}}</td><td>{{$formatoDgcft->grupo}}</td><td>{{$materia}}</td>
                            <td>{{$formatoDgcft->fec_inicio}}</td><td>{{$formatoDgcft->fec_fin}}</td>
                            <td>{{$formatoDgcft->horario_inicio}}</td><td>{{$formatoDgcft->horario_fin}}</td>
                            <td>{{$duracion_materias[$loop->index]}}</td><td>{{$formatoDgcft->cantidad_clientes}}</td>
                            <td></td><td></td><td></td><td></td>
                        </tr>
                        
                    @endforeach
                </tbody>
                
                
                
                
            </table>
            
            <table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF" class="Texto1" align="center">
                <thead>
                    <th colspan="2" width="50%"> INSCRIPCION </th><th colspan="2" width="50%"> ACREDITACION </th>
                </thead>
                <tr>
                    <tr>
                        <td align="center" valign="bottom" width="25%" height="100">
                            <span style="font-weight: bold">
                                <u>
                                {{$formatoDgcft->plantelR->director->nombre}} {{$formatoDgcft->plantelR->director->ape_paterno}} {{$formatoDgcft->plantelR->director->ape_materno}}
                                </u>
                            </span>
                            <br>
                              @if($formatoDgcft->plantelR->director->genero==1)
                              NOMBRE Y FIRMA DEL DIRECTOR
                              @else
                              NOMBRE Y FIRMA DE LA DIRECTORA
                              @endif
                        </td> 
                        <td align="center" valign="bottom" width="25%" height="50" >
                            <table width="100%"><tr><td style="border-bottom: 1px solid black;"></td></tr></table>
                              SELLO
                        </td> 
                        <td align="center" valign="bottom" width="25%" height="50"><span style="font-weight: bold"><u>
                        {{$formatoDgcft->plantelR->director->nombre}} {{$formatoDgcft->plantelR->director->ape_paterno}} {{$formatoDgcft->plantelR->director->ape_materno}}
                        </u></span><br>
                            @if($formatoDgcft->plantelR->director->genero==1)
                              NOMBRE Y FIRMA DEL DIRECTOR
                              @else
                              NOMBRE Y FIRMA DE LA DIRECTORA
                              @endif
                            </td> 
                        <td align="center" valign="bottom" width="25%" height="50">
                        <table width="100%"><tr><td style="border-bottom: 1px solid black;"></td></tr></table>
                              SELLO</td> 
                    </tr>
                    <tr>
                        <td align="center" valign="bottom" height="100"><span style="font-weight: bold"><u>{{$formatoDgcft->plantelR->enlace}}</u></span><br>
                              NOMBRE Y FIRMA DEL ENLACE OPERATIVO</td> 
                        <td align="center" valign="bottom" height="">
                        <table width="100%"><tr><td style="border-bottom: 1px solid black;"></td></tr></table>
                                SELLO</td> 
                        <td align="center" valign="bottom" height="50"><span style="font-weight: bold"><u>{{$formatoDgcft->plantelR->enlace}}</u></span><br>
                              NOMBRE Y FIRMA DEL ENLACE OPERATIVO</td> 
                        <td align="center" valign="bottom" height="">
                        <table width="100%"><tr><td style="border-bottom: 1px solid black;"></td></tr></table>
                                SELLO</td> 
                    </tr>
                </tbody>
            </table>    
            <br/>
            <table width="45%" border="0" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF" class="Texto1" align="center">
                <tbody><tr>
                      
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

