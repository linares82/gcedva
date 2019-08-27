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
                    <td>ENLACE OPERATIVO:<strong>{{$plantel->enlace_lugar}}</strong></td>
                    <td colspan="2">PLANTEL PARTICULAR: <strong>{{$plantel->razon}}</strong></td>
                    <td>CLAVE CCT: {{$especialidad->ccte}} </td>
                </tr>
                <tr>
                    <td colspan="2">CURSO/ESPECIALIDAD:<strong>{{$grado->nombre2}}</strong></td>
                    <td>GRUPO: <strong>{{$data['grupo']}}</strong></td>
                    <td>FECHA: {{$data['fecha']}} </td>
                </tr>
                <tr>
                    <td> FECHA DE INICIO:<strong>{{$data['fecha_inicio']}}</strong></td>
                    <td>FECHA DE FIN: <strong>{{$data['fecha_termino']}}</strong></td>
                    <td>DURACION EN HRS.: {{$data['duracion_horas']}} </td>
                    <td>HORARIO.: {{$data['horario']}} </td>
                </tr>
                
            </table>
            <br/>
            <table>
                <tr>
                    <th colspan="7" width="40%">INSCRIPCION</th><th colspan="9" width="60%">ACREDITACION</th>
                </tr>
                <tr>
                    <th rowspan="3" >N<br/>U<br/>M<br/>.</th><th rowspan="3">NUMERO DE CONTROL</th>
                    <th rowspan="3">NOMBRE DEL ALUMNO<br/>PRIMER APELLIDO / SEGUNDO APELLIDO * NOMBRE(S)</th><th rowspan="3">EDAD</th>
                    <th  rowspan="3">S<br/>E<br/>X<br/>O</th><th rowspan="3">E<br/>S<br/>C<br/>O<br/>L<br/>A<br/>R<br/>I<br/>D<br/>A<br/>D</th><th rowspan="3">B<br/>E<br/>C<br/>A<br/>%</th>
                    <th colspan="9"> NOMBRE DE LA MATERIA</th>
                </tr>
                <?php 
                foreach($registros as $registro){
                    $cliente=$registro->cliente;
                    break;
                }
                $materias=\App\Hacademica::select('m.name as materia','m.id')->where('cliente_id',$cliente)
                                     ->join('materia as m','m.id','=','hacademicas.materium_id')
                                     ->where('m.seriada_bnd','<>',1)
                                     ->get();
                //dd($materias->toArray());
                ?>
                <tr>
                    @foreach($materias as $materia)
                    <th>{{$materia->materia}}</th>
                    @endforeach
                    <th>RESULTADO <br/>FINAL</th>
                    
                </tr>
                <tr>
                    <th colspan="9">EVALUACIONES</th>
                </tr>
                
                <?php 
                    $i=1;
                    $hoy=\Carbon\Carbon::createFromFormat('Y-m-d', Date('Y-m-d'));
                ?>
                @foreach($registros as $registro)
                <tr>
                    <td>{{$i++}}</td><td>{{$registro->control}}</td><td>{{$registro->ape_paterno}} {{$registro->ape_materno}} {{$registro->nombre}} {{$registro->nombre2}}</td>
                    <?php 
                    if($registro->fec_nacimiento<>null){
                        $nacimiento=\Carbon\Carbon::createFromFormat('Y-m-d', $registro->fec_nacimiento);
                    }
                    ?>
                    <td>@if($registro->fec_nacimiento<>null) 
                        {{$hoy->DiffInYears($nacimiento) }}
                        @endif
                    </td>
                    <td>@if($registro->genero==1) M @elseif($registro->genero==2) F @endif</td><td>{{$registro->escolaridad_id}}</td><td>-</td>
                    @foreach($materias as $materia)
                        <?php 
                        $materia_calificacion=\App\Hacademica::select('m.name as materia','calif.calificacion')->where('cliente_id',$registro->cliente)
                                             ->join('materia as m','m.id','=','hacademicas.materium_id')
                                             ->join('calificacions as calif','calif.hacademica_id','=','hacademicas.id')
                                             ->where('m.seriada_bnd','<>',1)
                                             ->where('m.id',$materia->id)
                                             ->first();
                        //dd($materias->toArray());
                        ?>
                        @if(isset($materia_calificacion->calificacion))
                        <td>
                            {{$materia_calificacion->calificacion}}
                        </td>
                        @endif
                    @endforeach
                </tr>
                @endforeach
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

