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
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge grey; }
        th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; }
        td { font-size: 11px; padding: 5px 20px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #b8d1f3; }
      
        </style>

    </head>
    <body>
        <div id="printeArea">
            <table class="table table-condensed table-striped">
                <?php $grupo0=""; ?>
                @foreach($registros as $r)
                
                @if($grupo0<>$r->grupo)
                    
                    <!--<div style="page-break-after:always;"></div>-->
                        <tr>
                            <td colspan="28">
                                {{"Plantel: ".$r->plantel }} <br/>
                                {{"Grupo: ".$r->grupo}}<br/>
                                {{"Periodo Lectivo: ".$r->lectivo}}<br/>
                                {{"Profesor: ".$r->maestro}}<br/>
                                {{"Grado: ".$r->grado}}<br/>
                                {{"Materia: ".$r->materia}}<br/>
                            </td>
                        </tr>
                        <tr>
                        <th class="altura"><strong>Nombre(s)</strong></th>
                        <th class="altura"><strong>A. Paterno</strong></th>
                        <th class="altura"><strong>A. Materno</strong></th>
                        
                        @foreach($carga_ponderacions_enc as $carga_ponderacion_enc)
                            
                            <th class=""><strong >{{$carga_ponderacion_enc->name}}<br/>{{$carga_ponderacion_enc->porcentaje}}</strong></th>
                            
                        @endforeach
                        <th class="altura"><strong>Final</strong></th>
                        </tr>
                        <?php $grupo0=$r->grupo; ?>
                @endif
                            <tr>
                                <td>{{$r->nombre." ".$r->nombre2}}</td><td>{{$r->ape_paterno}}</td><td>{{$r->ape_materno}}</td>
                                <?php
                                    /*$fechas=\App\AsistenciaR::select('fecha')
                                            ->where('asignacion_academica_id',$r->asignacion)
                                            ->where('cliente_id',$r->cliente)
                                            ->whereNotIn('cliente_id',[0,2])
                                            ->get();
                                     * */
                                     $calificacion=\App\Calificacion::where('hacademica_id',$r->hacademica)->first();
                          
                                ?>
                                
                                @foreach($carga_ponderacions_enc as $carga_ponderacion_enc)
                                    @foreach($calificacion->calificacionPonderacions as $calificacionPonderacion)
                                        @if($carga_ponderacion_enc->id == $calificacionPonderacion->carga_ponderacion_id)
                                        <td class="centrar_texto">{{$calificacionPonderacion->calificacion_parcial}}</td>
                                        @endif
                                    @endforeach
                                @endforeach         
                                <td class="centrar_texto">{{$calificacion->calificacion}}</td>
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

