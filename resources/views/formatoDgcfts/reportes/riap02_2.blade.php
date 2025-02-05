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
        @php
            $emisiones = explode(',',$formatoDgcft->fechas_emision);
            //dd($emisiones);
        @endphp
        @foreach($emisiones as $emision)
            @php
                $iteracion_emision=$loop->index;
                $consecutivo_control=$formatoDgcft->control_inicio;
            @endphp
            @if($loop->first)
                <div id="printeArea" class='SaltoDePagina'>
                <table width="100%">
                    <tr>
                        <th><img src="{{asset('images/sep.jpg')}}" alt='logo_sep' width="250px;"></img></th>
                        <th align='center'>SUBSECRETARÍA DE EDUCACIÓN MEDIA SUPERIOR <br/>
                            DIRECCIÓN GENERAL DE CENTROS DE FORMACIÓN PARA EL TRABAJO <br/>
                            DIRECCIÓN TÉCNICA <br/>
                            SUBDIRECCIÓN DE VINCULACIÓN Y APOYO ACADÉMICO <br/>
                            REGISTRO DE INSCRIPCIÓN Y ACREDITACIÓN (RIAP-02) <br/>
                        </th>
                    </tr>
                </table>
                <br/>
                <table width="100%">
                    <tr>
                        <td>ENLACE OPERATIVO SCEO:<strong>{{$formatoDgcft->plantelR->enlace}}</strong></td>
                        <td colspan="2">PLANTEL PARTICULAR: <strong>{{$formatoDgcft->plantelR->denominacion}}</strong></td>
                        <td>CLAVE CCT: {{$formatoDgcft->plantelR->cct}} </td>
                    </tr>
                    <tr>
                        <td colspan="2">ESPECIALIDAD:<strong>{{$formatoDgcft->especialidad}}</strong></td>
                        <td>GRUPO: <strong>{{$formatoDgcft->grupo}}</strong></td>
                        <td>FECHA: {{$emision}} </td>
                    </tr>
                    <tr>
                        <td> FECHA DE INICIO:<strong>{{$formatoDgcft->fec_inicio}}</strong></td>
                        <td>FECHA DE FIN: <strong>{{$formatoDgcft->fec_fin}}</strong></td>
                        <td>DURACION EN HRS.: {{$formatoDgcft->duracion}} </td>
                        <td>HORARIO.: {{$formatoDgcft->horario}} </td>
                    </tr>
                    
                </table>
                <br/>
                <table>
                    <tr>
                        <th colspan="7" width="40%">INSCRIPCION</th><th colspan="{{count($materias)}}" width="60%">ACREDITACION</th><th colspan="2"></th>
                    </tr>
                    <tr>
                        <th rowspan="3" >N<br/>U<br/>M<br/>.</th><th rowspan="3">NUMERO DE CONTROL</th>
                        <th rowspan="3">NOMBRE DEL ALUMNO</th><th rowspan="3">EDAD</th>
                        <th  rowspan="3">SEXO</th><th rowspan="3">ESCOLARIDAD</th>
                        <th rowspan="3">BECA %</th>
                        <th colspan="{{count($materias)}}"> NOMBRE DE LA MATERIA</th>
                        <th rowspan="3">RESULTADO </th><th rowspan="3">FINAL</th>
                    </tr>
                    <tr>
                        @foreach($materias as $materia)
                        <th>{{$materia->name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th colspan="{{count($materias)}}">EVALUACIONES</th>
                    </tr>
                    
                    @php
                        $i=1;
                    @endphp

                    @foreach($formatoDgcft->formatoDgcftDetalles as $registro)
                    @if($registro->bnd_satisfactorio==1)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>
                        {{ $formatoDgcft->control_parte_fija }}{{ $registro->control }}
                        </td>
                        <td>{{$registro->nombre}}</td>
                        <td>
                            {{$registro->edad}}
                        </td>
                        <td>{{$registro->fec_sexo}}</td><td>{{$registro->escolaridad}}</td><td>{{$registro->beca}}</td>
                        @foreach($materias as $materia)
                            <td>
                                -
                            </td>
                        @endforeach
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    @endif
                    @endforeach
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
            
            @else
            <div id="printeArea" class='SaltoDePagina'>
                <table width="100%">
                    <tr>
                        <th><img src="{{asset('images/sep.jpg')}}" alt='logo_sep' width="250px;"></img></th>
                        <th align='center'>SUBSECRETARÍA DE EDUCACIÓN MEDIA SUPERIOR <br/>
                            DIRECCIÓN GENERAL DE CENTROS DE FORMACIÓN PARA EL TRABAJO <br/>
                            DIRECCIÓN TÉCNICA <br/>
                            SUBDIRECCIÓN DE VINCULACIÓN Y APOYO ACADÉMICO <br/>
                            REGISTRO DE INSCRIPCIÓN Y ACREDITACIÓN (RIAP-02) <br/>
                        </th>
                    </tr>
                </table>
                <br/>
                <table width="100%">
                    <tr>
                        <td>ENLACE OPERATIVO SCEO:<strong>{{$formatoDgcft->plantelR->enlace}}</strong></td>
                        <td colspan="2">PLANTEL PARTICULAR: <strong>{{$formatoDgcft->plantelR->denominacion}}</strong></td>
                        <td>CLAVE CCT: {{$formatoDgcft->plantelR->cct}} </td>
                    </tr>
                    <tr>
                        <td colspan="2">ESPECIALIDAD:<strong>{{$formatoDgcft->especialidad}}</strong></td>
                        <td>GRUPO: <strong>{{$formatoDgcft->grupo}}</strong></td>
                        <td>FECHA: {{$emision}} </td>
                    </tr>
                    <tr>
                        <td> FECHA DE INICIO:<strong>{{$formatoDgcft->fec_inicio}}</strong></td>
                        <td>FECHA DE FIN: <strong>{{$formatoDgcft->fec_fin}}</strong></td>
                        <td>DURACION EN HRS.: {{$formatoDgcft->duracion}} </td>
                        <td>HORARIO.: {{$formatoDgcft->horario}} </td>
                    </tr>
                    
                </table>
                <br/>
                <table>
                    <tr>
                        <th colspan="7" width="40%">INSCRIPCION</th><th colspan="{{count($materias)}}" width="60%">ACREDITACION</th><th colspan="2"></th>
                    </tr>
                    <tr>
                        <th rowspan="3" >N<br/>U<br/>M<br/>.</th><th rowspan="3">NUMERO DE CONTROL</th>
                        <th rowspan="3">NOMBRE DEL ALUMNO</th><th rowspan="3">EDAD</th>
                        <th  rowspan="3">SEXO</th><th rowspan="3">ESCOLARIDAD</th>
                        <th rowspan="3">BECA %</th>
                        <th colspan="{{count($materias)}}"> NOMBRE DE LA MATERIA</th>
                        <th rowspan="3">RESULTADO </th><th rowspan="3">FINAL</th>
                    </tr>
                    <tr>
                        @foreach($materias as $materia)
                        <th>{{$materia->name}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        <th colspan="{{count($materias)}}">EVALUACIONES</th>
                    </tr>
                    
                    @php
                        $i=1;
                    @endphp

                    @foreach($formatoDgcft->formatoDgcftDetalles as $registro)
                    @if($registro->bnd_satisfactorio==1)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>
                        {{ $formatoDgcft->control_parte_fija }}{{ $registro->control }}
                        </td>
                        <td>{{$registro->nombre}}</td>
                        <td>
                            {{$registro->edad}}
                        </td>
                        <td>{{$registro->fec_sexo}}</td><td>{{$registro->escolaridad}}</td><td>{{$registro->beca}}</td>
                        
                        @foreach($materias as $materia)
                            @if($loop->iteration==$iteracion_emision)
                            <?php 
                            $calificacion=App\FormatoDgcftMatCalif::where('sep_materia_id',trim($materia->sep_materia_id))
                            ->where('formato_dgcft_detalle_id',$registro->id)
                            ->first();
                            ?>
                            <td>
                                @php
                                    
                                @endphp
                                @if(!is_null($calificacion))
                                    {{$calificacion->calificacion }}
                                @endif
                            </td>
                            @else
                            <td>-</td>
                            @endif
                        @endforeach
                        @foreach($materias as $materia)
                            @if($loop->iteration==$iteracion_emision)
                            <?php 
                            $calificacion=App\FormatoDgcftMatCalif::where('sep_materia_id',trim($materia->sep_materia_id))
                            ->where('formato_dgcft_detalle_id',$registro->id)
                            ->first();
                            ?>
                            <td>
                                @if(!is_null($calificacion))
                                    {{$calificacion->calificacion }}
                                @endif
                            </td>
                            @endif
                        @endforeach
                        @foreach($materias as $materia)
                            @if($loop->iteration==$iteracion_emision)
                            <?php 
                            $calificacion=App\FormatoDgcftMatCalif::where('sep_materia_id',trim($materia->sep_materia_id))
                            ->where('formato_dgcft_detalle_id',$registro->id)
                            ->first();
                            ?>
                            <td>
                                @if(!is_null($calificacion))
                                    {{$calificacion->calificacion }}
                                @endif
                            </td>
                            
                            @endif
                        @endforeach
                    </tr>
                    @endif
                    @endforeach
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
            @endif

            
        @endforeach
        
        <script type="text/php">
            /*if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            $pdf->page_text(670, 580, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }*/
        </script>

    </body>
</html>

