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
        table, #chart_div { margin: auto; font-family: Segoe UI; border: thin ridge grey; }
        .tbl1 th { background: #0046c3; color: #fff; max-width: 400px; padding: 5px 10px; font-size: 11px;}
        .tbl1 td { font-size: 10px; padding: 5px 20px; color: #000; }
        .tbl1 tr { background: #b8d1f3; }
        .tbl1 tr:nth-child(even) { background: #dae5f4; }
        .tbl1 tr:nth-child(odd) { background: #b8d1f3; }
      
        table.blueTable {
            width: 60%;
            text-align: center;
            border-collapse: collapse;
          }
          table.blueTable .td1{
            height: 100px;
          }
          table.blueTable .tdw{
            width: 33%;
          }
          table.blueTable td, table.blueTable th {
            border: 1px solid #AAAAAA;
          }
          
          table.blueTable thead th {
            font-weight: bold;
            text-align: center;
          }
        
        </style>

    </head>
    <body>
        
        <div id="printeAreaLista">
            <h3>Lista de Calificaciones del {{$asignacion->fec_inicio}} al {{$asignacion->fec_fin}} </h3>
            <table class="tbl1">
                <?php 
                    $grupo0=""; 
                    $instructor="";
                    $cantidad_registros=0;
                    $promedios=array();
                    $promedio_totales=0;
                ?>
                <?php $contador_linea=1; ?>
                @foreach($registros as $r)
                    <?php $cantidad_registros++; 
                    $plantel_id=$r->plantel_id;
                    ?>
                @if($grupo0<>$r->grupo)
                    
                    <!--<div style="page-break-after:always;"></div>-->
                        <tr>
                            <td colspan="6">
                                {{"Plantel: ".$r->plantel }} <br/>
                                {{"Grupo: ".$r->grupo}}<br/>
                                {{"Periodo Lectivo: ".$r->lectivo}}<br/>
                                {{"Profesor: ".$r->maestro}}<br/>
                                {{"Grado: ".$r->grado}}<br/>
                                {{"Materia: ".$r->materia}}<br/>
                                <?php
                                $instructor=$r->maestro;
                                ?>
                            </td>
                            <td colspan="{{$contador}}">
                                <img src="{{ asset('/imagenes/planteles/'.$r->p_id."/".$r->logo) }}" alt="Sin logo" height="80px" ></img>
                            </td>
                            <td></td><td></td>
                        </tr>
                        <tr>
                            <th></th>
                        <th class="altura"><strong>NO.</strong></th>    
                        <th class="altura"><strong>Nombre(s)</strong></th>
                        <th class="altura"><strong>A. Paterno</strong></th>
                        <th class="altura"><strong>A. Materno</strong></th>
                        
                        @foreach($carga_ponderacions_enc as $carga_ponderacion_enc)
                            
                            <th class=""><strong >{{$carga_ponderacion_enc->name}}<br/>{{$carga_ponderacion_enc->porcentaje}}</strong></th>
                            
                        @endforeach
                        <th class="altura"><strong>Final</strong></th>
                        <th class="altura"><strong>Extraordinario</strong></th>
                        <th class="altura" width=150px><strong>Firma</strong></th>
                        </tr>
                        <?php $grupo0=$r->grupo; ?>
                @endif
                        
                            <tr>
                                <td>{{$contador_linea++}}</td>
                                <td>{{ $r->cliente }}</td>
                                <td>{{$r->nombre." ".$r->nombre2}}</td><td>{{$r->ape_paterno}}</td><td>{{$r->ape_materno}}</td>
                                <?php
                                    /*$fechas=\App\AsistenciaR::select('fecha')
                                            ->where('asignacion_academica_id',$r->asignacion)
                                            ->where('cliente_id',$r->cliente)
                                            ->whereNotIn('cliente_id',[0,2])
                                            ->get();
                                     * */
                                     $calificacion=\App\Calificacion::where('hacademica_id',$r->hacademica)
                                                                                    ->where('tpo_examen_id',1)
                                                                                    ->first();
                                     $extra=\App\Calificacion::where('hacademica_id',$r->hacademica)
                                                                                    ->where('tpo_examen_id',2)
                                                                                    ->first();                                               
                                     $marcador_extra_impreso=0;
                                     
                                     
                                ?>
                                
                                @foreach($carga_ponderacions_enc as $carga_ponderacion_enc)
                                            @foreach($calificacion->calificacionPonderacions as $calificacionPonderacion)
                                                @if($carga_ponderacion_enc->id == $calificacionPonderacion->carga_ponderacion_id)
                                                <td class="centrar_texto">{{$calificacionPonderacion->calificacion_parcial}}</td>
                                                <?php 
                                                if(!isset($promedios[$calificacionPonderacion->carga_ponderacion_id])){
                                                    $promedios[$calificacionPonderacion->carga_ponderacion_id]=0;                                            
                                                }
                                                $promedios[$calificacionPonderacion->carga_ponderacion_id] = $promedios[$calificacionPonderacion->carga_ponderacion_id]+$calificacionPonderacion->calificacion_parcial;                                         
                                                ?>
                                                @endif
                                            @endforeach
                                @endforeach
                                <td class="centrar_texto">{{$calificacion->calificacion}}</td>
                                @if(is_object($extra))
                                    <td class="centrar_texto">{{$extra->calificacion}}</td>                    
                                @else
                                    <td class="centrar_texto">N/A</td>
                                @endif
                                <td height=40px></td>
                                <?php $promedio_totales=$promedio_totales+$calificacion->calificacion;?>
                            </tr>
                            
                @endforeach
                
                <tr>
                    <td></td><td></td><td></td><td></td><td> <?php //dd($promedios); ?> </td>
                    @foreach($promedios as $promedio)
                    <td> {{ round($promedio/$cantidad_registros,2) }}</td>
                    @endforeach
                    @if($promedio_totales>0)
                    <td>{{round($promedio_totales/$cantidad_registros,2)}}</td>
                    @endif
                    <td></td><td></td>
                </tr>
            </table>
            <br/>
            <br/>
            <br/>
            <table class='blueTable'>
                <tr class='td1'><td></td><td></td><td></td><td></td><td></td></tr>
                <?php 
                $plantel=App\Plantel::find($plantel_id);
                ?>
                <tr><td class='tdw'>{{$instructor}}</td><td></td><td class='tdw'>Sello del Plantel</td><td></td><td>{{$plantel->director->nombre}} {{$plantel->director->ape_paterno}} {{$plantel->director->ape_materno}}</td></tr>
                <tr><td>Instructor Titular</td><td></td><td></td><td></td><td class='tdw'>Firma de Director:</td></tr>
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

