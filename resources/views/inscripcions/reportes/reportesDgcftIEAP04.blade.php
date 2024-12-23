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
                    <td>ENLACE OPERATIVO:<strong>{{$plantel->enlace_lugar}}</strong></td>
                    <td colspan="2">PLANTEL PARTICULAR: <strong>{{$plantel->razon}}</strong></td>
                    <td>CLAVE CCT: {{$especialidad->ccte}} </td>
                </tr>
                <tr>
                    <td colspan="2">Ubicacion:<strong>{{$plantel->calle}} No. {{$plantel->no_ext}}, col. {{$plantel->colonia}},
                    {{$plantel->municipio}}, {{$plantel->estado}}, CP. {{$plantel->cp}}
                    </strong></td>
                    
                    <td>FECHA ELABORACION: {{DATE('d-m-Y')}} </td>
                    <td>CICLO ESCOLAR:</td>
                </tr>
                
            </table>
            <br/>
            <table width="100%">
                <thead>
                <tr>
                    <th colspan="7" width="60%"></th><th colspan="9" width="40%">ACREDITACION</th>
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
                    @foreach ($registros as $registro)
                        <tr>
                            <td>{{$registro['grado']}}</td><td></td><td>{{$registro['materia']}}</td><td>{{$registro['inicio']}}</td><td>{{$registro['fin']}}</td>
                            <td>{{$registro['hora_inicio']}}</td><td>{{$registro['hora_fin']}}</td><td>{{$registro['horas']}}</td><td>{{$registro['inscritos']}}</td>
                            <td></td><td></td><td></td><td></td>
                        </tr>
                    @endforeach
                </tbody>
                
                
                
                
            </table>
            
            <table width="100%" border="0" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF" class="Texto1" align="center">
                <thead>
                    <th colspan="4" width="50%"> INSCRIPCION </th><th colspan="4" width="50%"> ACREDITACION </th>
                </thead>
                <tbody>
                    <tr>
                        <td align="center" valign="bottom" height="50"><span style="font-weight: bold"><u>{{$plantel->director->nombre}} {{$plantel->director->ape_paterno}} {{$plantel->director->ape_materno}}</u></span><br>
                              NOMBRE Y FIRMA DEL DIRECTOR</td> 
                        <td align="center" valign="bottom" height="50"><span style="font-weight: bold">|____________________|</span><br>
                              SELLO</td> 
                        <td align="center" valign="bottom" height="50"><span style="font-weight: bold"><u>{{$plantel->enlace}}</u></span><br>
                              NOMBRE Y FIRMA DEL ENLACE OPERATIVO</td> 
                        <td align="center" valign="bottom" height=""><span style="font-weight: bold">|___________________|</span><br>
                                SELLO</td> 
                        <td align="center" valign="bottom" height="50"><span style="font-weight: bold"><u>{{$plantel->director->nombre}} {{$plantel->director->ape_paterno}} {{$plantel->director->ape_materno}}</u></span><br>
                              NOMBRE Y FIRMA DEL DIRECTOR</td> 
                        <td align="center" valign="bottom" height="50"><span style="font-weight: bold">|____________________|</span><br>
                              SELLO</td> 
                        <td align="center" valign="bottom" height="50"><span style="font-weight: bold"><u>{{$plantel->enlace}}</u></span><br>
                              NOMBRE Y FIRMA DEL ENLACE OPERATIVO</td> 
                        <td align="center" valign="bottom" height=""><span style="font-weight: bold">|___________________|</span><br>
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
            @if($data['bnd_detalle'][0]==1) 
            <table>
                <thead>
                    <th>CSC</th>
                    <th>Inscripcion</th><th>Cliente</th><th>Plantel</th>
                    <th>Especialidad</th><th>Nivel</th><th>Grado</th>
                    <th>lectivo</th><th>Grupo</th><th>Materia</th>
                    <th>St. Materia</th><th>Periodo Estudio</th><th>Turno</th>
                    <th>Grupo</th><th>St. Cliente</th>
                </thead>
                <tbody>
                    @php
                        $i=0;
                    @endphp
                    @foreach($registros_detalle as $linea)
                    <tr><td>{{++$i}}</td>
                        <td>{{$linea['inscripcion_id']}}</td>
                        <td>{{$linea['cliente_id']}} {{$linea['ape_paterno']}} {{$linea['ape_materno']}} {{$linea['nombre']}} {{$linea['nombre2']}}</td>
                        <td>{{$linea['plantel_id']}}{{$linea['razon']}}</td>
                        <td>{{$linea['especialidad_id']}} {{$linea['especialidad']}}</td><td>{{$linea['nivel_id']}} {{$linea['nivel']}}</td><td>{{$linea['grado_id']}} {{$linea['grado']}}</td>
                        <td>{{$linea['lectivo_id']}} {{$linea['lectivo']}}</td><td>{{$linea['grupo_id']}} {{$linea['grupo']}}</td><td>{{$linea['materium_id']}} {{$linea['materia']}}</td>
                        <td>{{$linea['st_materium_id']}} {{$linea['st_materia']}}</td><td>{{$linea['periodo_estudio_id']}} {{$linea['periodo_estudio']}}</td><td>{{$linea['turno_id']}}</td>
                        <td>F {{$linea['grupo_id']}} {{$linea['grupo']}}</td>
                        <td>F {{$linea['st_cliente_id']}} {{$linea['st_cliente']}}</td>
                    </tr>

                    @endforeach
                </tbody>
            </table>
            @endif
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

