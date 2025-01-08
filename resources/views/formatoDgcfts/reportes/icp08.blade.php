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
          width:700px;
          padding:10px;

         }
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
        @foreach($detalles as $registro)
        <div id="printeArea" class='SaltoDePagina'>
            <table width="95%">
                <tr>
                    <th><img src="{{asset('images/sep.jpg')}}" alt='logo_sep' width="250px;"></img></th>
                    <th align='center'>SUBSECRETARÍA DE EDUCACIÓN MEDIA SUPERIOR  <br/>
                            DIRECCIÓN GENERAL DE CENTROS DE FORMACIÓN PARA EL TRABAJO<br/>
                            INFORME DE CALIFICACIONES<br/>
                            (ICP-08)</th>
                </tr>
            </table>
            <br/>
            <table width="95%">
                <tr>
                    <td> EL PLANTEL PARTICULAR:<strong>{{$formatoDgcft->plantelR->denominacion}}</strong></td><td>CLAVE CCT: <strong>{{$formatoDgcft->plantelR->cct}}</strong></td>
                </tr>
                <tr>
                    <td> HACE CONSTAR QUE EL ALUMNO:<strong>{{$registro->nombre}} </strong> </td><td>CON NÚMERO DE CONTROL: <strong>{{$registro->control}}</strong></td>
                </tr>
                <tr>
                    <td colspan='2'>  Y CLAVE CURP <strong>{{$registro->curp}}</strong> OBTUVO LAS SIGUIENTES  CALIFICACIONES EN LA ESPECIALIDAD DE: <strong>{{$registro->grado}}</strong></td>
                </tr>
            </table>
            <br/>
            <table width="95%">
                <tr >
                    <th width="75%">MATERIA/MÓDULO/NIVEL/CURSO</th><th width="25%">CALIFICACIÓN NUMÉRICA</th>
                </tr>
                @php
                    $cantidad_materias=0;
                @endphp
                @foreach($registro->formatoDgcftMatCalifs as $materia)
                <tr>
                    <td>{{$materia->materia}}</td><td>{{$materia->calificacion}}</td>
                </tr>
                <?php $cantidad_materias++; ?>
                @endforeach
            </table>
            <br/>
            <table width="95%">
                <tr>
                    <td>
                        LA ESCALA DE CALIFICACIÓN ES DEL 5 AL 10 SIENDO 6 LA MÍNIMA PARA SER PROMOVIDO,  CONFORME AL ACUERDO NÚMERO 17
                    </td>
                </tr>
                <tr>
                    <td >
                        SE EXTIENDE EL PRESENTE CON <strong>{{$cantidad_materias}} CURSOS </strong> ACREDITADOS.
                    </td>
                </tr>
                <tr>
                    <td align="center">
                        <?php 
                        $fecha_elaboracion=Carbon\Carbon::createFromFormat('Y-m-d',$formatoDgcft->fec_elaboracion); 
                        $monthNum=$fecha_elaboracion->month;
                        $mes=\App\Mese::find($monthNum);
                        ?>
                        A {{ $fecha_elaboracion->day }} DE {{ strtoupper($mes->name) }} DE {{ $fecha_elaboracion->year}}</strong>
                    </td>
                </tr>
            </table>
            <br/>
            <table width="95%" border="0" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF" class="Texto1" align="center">      
                <tr>
                <td align="center" valign="bottom" width="25%" height="50"><span style="font-weight: bold"><u>
                        {{$formatoDgcft->plantelR->director->nombre}} {{$formatoDgcft->plantelR->director->ape_paterno}} {{$formatoDgcft->plantelR->director->ape_materno}}
                        </u></span><br>
                            @if($formatoDgcft->plantelR->director->genero==1)
                              NOMBRE Y FIRMA DEL DIRECTOR
                              @else
                              NOMBRE Y FIRMA DE LA DIRECTORA
                              @endif
                            </td>  
                    <td align="center" valign="bottom" width="25%" height="50" >
                        <table width="100%" ><tr><td style="border-bottom: 1px solid black;"></td></tr></table>
                            SELLO
                    </td> 
                </tr>
                <tr>
                    <td align="center" valign="bottom" height="100"><span style="font-weight: bold"><u>{{$formatoDgcft->plantelR->enlace}}</u></span><br>
                            NOMBRE Y FIRMA DEL ENLACE OPERATIVO</td> 
                    <td align="center" valign="bottom" height="">
                    <table width="100%"><tr><td style="border-bottom: 1px solid black;"></td></tr></table>
                            SELLO</td> 
                    
                </tr>
            
            </table>   
        </div>
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

