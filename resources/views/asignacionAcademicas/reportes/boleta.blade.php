<html>
  <head>
      <style>
        h1, h3, h5, th { text-align: center; }
        body{
           font-family: Arial;
           font-size: 0.8em;
        }
        
        
        .table_format {
            border: 1px solid #ddd;
            font-size: 8px;
            border-collapse: collapse;
        }
        
        .table_format2 {
            border: 1px solid #ddd;
            font-size: 8px;
            border-collapse: collapse;
            margin: 10px auto;
        }
        
        .table_format td {
            border: 1px solid #ddd;
            font-size: 8px;
            border-collapse: collapse;
            text-align: center;
        }
        
        .table_format th {
            border: 1px solid #ddd;
            font-size: 8px;
            border-collapse: collapse;
            text-align: center;
        }
        .SaltoDePagina{
         page-break-after: always;
         padding:10px;
        }
      </style>
    
    
  </head>
  <body>
    
        @foreach($clientes as $c)
        <?php 
        $cliente= \App\Cliente::find($c->id);
        
        ?>
        <div class="SaltoDePagina">
            <?php
            $inscripcion= \App\Inscripcion::find($c->inscripcion_id);
             
    /*            $inscripcion= \App\Inscripcion::where('plantel_id',$c->plantel_id)
                                              ->where('especialidad_id',$c->especialidad_id)
                                              ->where('nivel_id',$c->nivel_id)
                                              ->where('grado_id',$c->grado_id)
                                              ->where('grupo_id',$c->grupo_id)
                                              ->where('lectivo_id',$c->lectivo_id)
                                              ->first()*/
                ?>
        <table width="100%">
            <td> <img src="{{ asset('storage/especialidads/'.$c->imagen) }}" alt="Sin logo" height="80px" ></img></td>
            
        </table>
        
        <table width="100%">
            <tr>
                <td> Nombre: {{$cliente->nombre." ".$cliente->nombre2." ".$cliente->ape_paterno." ".$cliente->ape_materno}}</td>
                <td>Fecha Impresión:{{Date('d-m-Y')}}</td>
            </tr>
            <tr>
                <td colspan="3">{{$inscripcion->grado->denominacion}}</td>
                
            </tr>
        </table>
            

            <table width="100%" class='table_format'>
                <thead>
                <th>Especialidad</th><th>Nivel</th>
                <th>Area</th><th>Grupo</th><th>F. Inscripcion</th>
                <th>Periodo Lectivo</th>
                <th>Matricula</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$c->especialidad}}</td>
                        <td>{{$c->nivel}}</td>
                        <td>{{$c->rvoe}}</td>
                        <td>{{$c->grupo}}</td>
                        <td>{{date_format($inscripcion->created_at,'d-m-Y')}}</td>
                        <td>{{$c->lectivo}}</td>
                        <td>{{$c->matricula}}</td>
                    </tr>
                    <tr>
                        <td colspan='8'>
                    <?php 
                        $hacademicas= \App\Hacademica::select('hacademicas.*')->where('hacademicas.plantel_id',$c->plantel_id)
                      ->join('inscripcions as i','i.id','=','hacademicas.inscripcion_id')
                                          ->where('hacademicas.especialidad_id',$c->especialidad_id)
                                          ->where('hacademicas.nivel_id',$c->nivel_id)
                                          ->where('hacademicas.grado_id',$c->grado_id)
                                          ->where('hacademicas.grupo_id',$c->grupo_id)
                                          ->where('hacademicas.lectivo_id',$c->lectivo_id)
                                          ->where('hacademicas.cliente_id',$c->id)
					  ->where('hacademicas.inscripcion_id',$c->inscripcion_id)	
					  ->whereNull('hacademicas.deleted_at')
					  ->whereNull('i.deleted_at')
                                          ->get();
                    ?>        
                    <table class='table_format' width='100%'>
                        <thead>
                        <th colspan='8'>Materias</th>
                        </thead>
                        <tbody>
                            @php
                                $cantidad_materias=0;
                                $sumatoria_calificaciones=0;
                            @endphp
                            @foreach($hacademicas as $a)
                            <tr>
                                <td colspan='3'>
                                    @if(optional($a->materia)->bnd_tiene_nombre_oficial==1)
                                    {{optional($a->materia)->name}}
                                    @else
                                    {{optional($a->materia)->name}}
                                    @endif
                                </td>
                                
                                <td colspan="5">
                                    <table class='table_format' width='100%'>
					
                                        <tbody>
                                            @php
                                                
						
                                                $calificaciones=\App\Calificacion::where('hacademica_id',$a->id)->whereNull('deleted_at')->get();
                                                //dd($calificaciones->ToArray());
                                            @endphp
					    
                                            @foreach($a->calificaciones as $cali)
                                            <tr>
                                                
                                                <tr>
						    
                                                    <strong>Tipo de examen:{{  $cali->tpoExamen->name}} - </strong>
                                                    @foreach($cali->calificacionPonderacions as $calificacionPonderacion)
                                                        <th class="centrar_texto">{{$calificacionPonderacion->cargaPonderacion->name}}</th>
                                                    @endforeach
                                                    <th>Promedio Real {{ $cali->tpo_examen_id==1 ? 'O.' : 'E.'}}  </th>
                                                </tr>
                                                <tr>
                                                    <strong>Calificacion Sin Ponderar: <!--@{{$cali->calificacion<6 ? ($cali->calificacion % 1) : round($cali->calificacion,0)}}--></strong>
                                                    @php
                                                        $cantidad_materias_validas=0;
                                                        $sumatoria_calificacions_validas=0;
                                                    @endphp
                                                    @foreach($cali->calificacionPonderacions as $calificacionPonderacion)
                                                        @if(is_null($calificacionPonderacion->deleted))
                                                        <td class="centrar_texto">{{round($calificacionPonderacion->calificacion_parcial,2)}}</td>
                                                        @php
                                                         if($calificacionPonderacion->calificacion_parcial>0){
                                                            $cantidad_materias_validas++;
                                                            $sumatoria_calificacions_validas=$sumatoria_calificacions_validas+$calificacionPonderacion->calificacion_parcial;
                                                        }   
                                                        @endphp
                                                        @endif
                                                    @endforeach
                                                        <td>{{$cali->calificacion<6 ? (intdiv($cali->calificacion,1)) : round($cali->calificacion,0)}} </td>
                                                    @if($cantidad_materias_validas>0)
                                                    @if(($sumatoria_calificacions_validas/$cantidad_materias_validas)>=6)    
                                                    {{ round($sumatoria_calificacions_validas/$cantidad_materias_validas) }}
                                                    @else
                                                     {{ intdiv(($sumatoria_calificacions_validas/$cantidad_materias_validas),1) }}
                                                    @endif
                                                    @else
                                                        0
                                                    @endif
                                                </tr>
                                            <tr>
                                            
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @php
                                $sumatoria_calificaciones=$sumatoria_calificaciones+ ($cali->calificacion<6 ? (intdiv($cali->calificacion,1)) : round($cali->calificacion,0));
                                $cantidad_materias++;
                            @endphp
                            @endforeach
                            
                            
                        </tbody>
                        </table>
                            
                        </tbody>
                        </table>
                        
                        </tr>
                        
                        </tbody>
                        
                    </table>
                    <table width="100%" class='table_format'>
                        @php
                            $promedio=$sumatoria_calificaciones/$cantidad_materias;
                        @endphp
                        <tr><td>Promedio General Real </td><td> {{ round($promedio,2) }}</td></tr>
                    </table>
                        
                    
                    
                            </td>
                            
                

                <table width='500px' class='table_format table_format2'>
                    <tr><td><br/><br/><br/><br/><br/><br/><br/><br/>
		     {{$cliente->plantel->director->nombre}} {{$cliente->plantel->director->ape_paterno}} {{$cliente->plantel->director->ape_materno}}
		    </td>
                        <!--<td >
                            <img src="data:image/png;base64, 
                                {!! base64_encode(QrCode::format('png')->size(100)->generate('Cliente:'.$c->id.', Promedio:'.$promedio)) !!} ">    

                        </td>
                        <td > </td>
			-->
		    </tr>
                    <tr><td ></td><!--<td ></td><td ></td>--></tr>
                    <tr><td>Director</td>
                           <!--<td></td>
                           <td>Instructor del Area</td>-->
                    </tr>
                </table
                
                <table width="95%" class="table_format">
                    <tbody><tr>
                     <td width="68%" bordercolor="#FFFFFF"><div align="center" class="textoACTAS3">CONTROL DE BOLETAS ENTREGADAS</div></td>
                     <td width="32%" bordercolor="#FFFFFF"><div align="center"><span style="font-weight: bold"></span></div></td>
                    </tr>
                    <tr>
                      <td colspan="2" bordercolor="#FFFFFF"><p>Promedio  general evaluatorio entregado a: <span style="font-weight: bold">{{$cliente->nombre." ".$cliente->nombre2." ".$cliente->ape_paterno." ".$cliente->ape_materno}}</span>, que acredita  tanto su conocimiento, habilidades y destrezas adquiridas en <u>{{$c->grado}}</u> 
                        
                       </p></td>
                      </tr>
                    <tr>
                      <td colspan="2" bordercolor="#FFFFFF">Del ciclo escolar correspondiente: {{$c->lectivo}}.</td>
                      </tr>
                    <tr>
                      <td height="70" align="center" valign="bottom" bordercolor="#FFFFFF"><strong>____________________________________________________</strong><br>
                        Nombre y firma del padre o tutor (enterado y de conformidad)</td>
                      <td align="center" valign="bottom" bordercolor="#FFFFFF"><br>
                  <br>

                        Huella</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        @endforeach        
    
    
  </body>
</html>
