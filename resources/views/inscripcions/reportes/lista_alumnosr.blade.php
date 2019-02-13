<html>
    <head>
        <style>
            @media print {
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
                /*border-collapse: collapse;*/
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
                /*padding: 8px;*/
                transform: rotate(270deg);
                height: auto;
                
            }
            
            .centrar_texto {
                text-align: center;
                padding: 8px;
            }
            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>

    </head>
    <body>
        <div id="printeArea">
            <table>
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
                            </td>
                        </tr>
                        <tr>
                        <th class="altura"><strong>Nombre(s)</strong></th>
                        <th class="altura"><strong>A. Paterno</strong></th>
                        <th class="altura"><strong>A. Materno</strong></th>
                        <?php $i=0 ?>
                        @foreach($fechas_enc as $fecha_enc)
                            @if($i>0)
                            <th class=""><strong >{{$fecha_enc}}</strong></th>
                            @endif
                            <?php $i=1 ?>
                        @endforeach
                        </tr>
                        <?php $grupo0=$r->grupo; ?>
                @endif
                            <tr>
                                <td>{{$r->nombre." ".$r->nombre2}}</td><td>{{$r->ape_paterno}}</td><td>{{$r->ape_materno}}</td>
                                <?php
                                    $fechas=\App\AsistenciaR::where('asignacion_academica_id',$r->asignacion)
                                            ->where('cliente_id',$r->cliente)
                                            ->whereNotIn('cliente_id',[0,2])
                                            ->get();
                                    $i=0;
                                ?>
                                @foreach($fechas_enc as $fecha_enc)
                                    @if($i>0)
                                        @foreach($fechas as $fecha)      
                                            @if($fecha_enc==$fecha->fecha)
                                            <?php 
                                            $st_asistencia= \App\EstAsistencium::find($fecha->est_asistencia_id)    
                                            ?>
                                            <td class="centrar_texto"> {{$st_asistencia->name}} </td>
                                            @endif
                                            
                                        @endforeach    
                                    @endif
                                    <?php $i=1; ?>
                                @endforeach         
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

