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
              h1, h3, h5, th { text-align: center; }
        table, #chart_div { margin: auto; font-family: Segoe UI; box-shadow: 10px 10px 5px #888; border: thin ridge gray; }
        th { font-size: 11px; background: #0046c3; color: #fff; max-width: 400px; padding: 2px 5px; }
        td { font-size: 10px; padding: 2px 10px; color: #000; }
        tr { background: #b8d1f3; }
        tr:nth-child(even) { background: #dae5f4; }
        tr:nth-child(odd) { background: #fff; }
      
        </style>

    </head>
    <body>
        <div id="printeArea">
            <h3>Lista de Asistencia del {{$data['fecha_f']}} al {{$data['fecha_t']}}</h3>
            
            
            <table>
                <?php 
                $grupo0="";
                $asistencias_acumuladas=0;
                $total_registros=0;
                 
                ?>
                @foreach($registros as $r)
                
                @if($grupo0<>$r->grupo)
                    
                    <!--<div style="page-break-after:always;"></div>-->
                        <tr>
                            <td colspan="5">
                                {{"Plantel: ".$r->plantel }} <br/>
                                {{"Grupo: ".$r->grupo}}<br/>
                                {{"Periodo Lectivo: ".$r->lectivo}}<br/>
                                {{"Profesor: ".$r->maestro}}<br/>
                                {{"Grado: ".$r->grado}}<br/>
                                {{"Materia: ".$r->materia}}<br/>
                            </td>
                            <td colspan="{{$contador}}">
                                <img src="data:image/png;base64, 
                        {!! base64_encode(QrCode::format('png')->size(100)->generate('Asignacion:'.$asignacion->id.
                        ', Alumnos Inscritos:'.$total_alumnos.', rango:'.$data['fecha_f'].':'.$data['fecha_t'].', token:'.$token)) !!} ">
                                <img src="{{ asset('/storage/especialidads/'.$r->logo) }}" alt="Sin logo" height="80px" ></img>
                            </td>
                        </tr>
                        <tr>
                        <th></th>
                        <th class="altura"><strong>NO.</strong></th>
                        <th class="altura"><strong>A. Paterno</strong></th>
                        <th class="altura"><strong>A. Materno</strong></th>
                        <th class="altura"><strong>Nombre(s)</strong></th>
                        <th class="altura"><strong>Tel. Fijo</strong></th>
                        <th class="altura"><strong>Adeudos</strong></th>
                        
                        @foreach($fechas_enc as $fecha_enc)
                            
                            <th class=""><strong >{{$fecha_enc}}</strong></th>
                            
                        @endforeach
                        <td>Total</td>
                        </tr>
                        <?php 
                        
                        $grupo0=$r->grupo; 
                        $asistencias=0;
                        $contador_linea=1;
                        ?>
                        
                @endif
                            <tr>
                                <td>{{$contador_linea++}}</td>
                                <td>{{ $r->cliente }}</td>
                                <td>{{$r->ape_paterno}}</td><td>{{$r->ape_materno}}</td><td>{{$r->nombre." ".$r->nombre2}}</td><td>{{$r->tel_fijo}}</td>
                                @php
                                 $hoy=Date('Y-m-d');
                                    $adeudos=\App\Adeudo::where('cliente_id',$r->cliente)
                                                                     ->whereNull('deleted_at')
                                                                     ->where('pagado_bnd',0)
                                                                     ->where('fecha_pago','<',$hoy)
                                                                     ->count();
                                @endphp
                                <td>{{$adeudos}}</td>
                                <?php
                                    $fechas=\App\AsistenciaR::where('asignacion_academica_id',$r->asignacion)
                                            ->where('cliente_id',$r->cliente)
                                            //->whereNotIn('cliente_id',[0,2])
                                            ->get();
				    //dd($fechas->toArray());
                                 
                                ?>
                                @foreach($fechas_enc as $fecha_enc)
                                    <?php $marcador=0; 
                                    $marca=""?>
                                    
                                        @foreach($fechas as $fecha)      
                                            @if($fecha_enc==$fecha->fecha)
                                            <?php 
                                            $st_asistencia= \App\EstAsistencium::find($fecha->est_asistencia_id);
                                            if($st_asistencia->id==1){
                                                $asistencias++;
                                                $marcador=1;
                                                $marca='X';
                                            }elseif($st_asistencia->id==3){
                                                $asistencias++;
                                                $marca='R';
                                                $marcador=1;
                                            }elseif($st_asistencia->id==4){
                                                $asistencias++;
                                                $marca='J';
                                                $marcador=1;
                                            }
                                            
                                            
                                            ?>
                                            @endif
                                            
                                        @endforeach    
                                        
                                    
                                    <?php $i=1; ?>
                                    @if($marcador==0)
                                        <td></td>
                                    @else
                                        <td class="centrar_texto"> {{ $marca }} </td>

                                    @endif               
                                                  
				@endforeach
                                <?php 
                                //$porcentaje = round((($asistencias*100)/$total_asistencias),2);
                                //$asistencias_acumuladas=$asistencias+$asistencias_acumuladas;
                                //$total_registros++;
                                 
                                 
                                ?>
                                <td>{{$asistencias}}</td>
                                <?php 
                                $caja=\App\Caja::where('cliente_id',$r->id)->latest()->first();
                                ?>
                                @if(is_object($caja))
                                <td>{{$caja->id."-".$caja->stCaja->name." - ".$caja->total." - ".$caja->fecha}}</td>
                                @endif
                                <?php 
                                $asistencias=0;
                                ?>
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

