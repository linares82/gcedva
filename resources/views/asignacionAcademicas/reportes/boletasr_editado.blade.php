<html>
    <head>
<style>
body { background-image:url(../../../img/pixel.png)}
.SaltoDePagina
 {
  page-break-after: always;
  width:700px;
  padding:10px;
 
 }
 tr
 {
  page-break-before: auto
 }
 .verticaltext {
				text-align:center;
				writing-mode: tb-rl;
				filter: flipv fliph;
	-o-transform: rotate(90deg);
    -moz-transform: rotate(90deg);
    -webkit-transform: rotate(90deg);
	            }
 .TablaCalifTitulo {
	 font-family:Verdana, Geneva, sans-serif;
	 font-size:7pt;
	 color:#000;
	 font-weight:bold;
	 background:#EAF4FF;
	 text-align:center;
 }
 .TablaCalifTexto {
	 font-family:Verdana, Geneva, sans-serif;
	 font-size:7pt;
	 color:#000;
	 font-weight:normal;
 }
 .TablaCalifTexto2 {
	 font-family:Verdana, Geneva, sans-serif;
	 font-size:5pt;
	 color:#000;
	 font-weight:normal;
 }
 .CeldaSombreada {
	 font-family:Verdana, Geneva, sans-serif;
	 font-size:7pt;
	 font-weight:bold;
	 color:#000;
	 background-color:#E8E8E8;
	 font-weight:normal;
 }
 .PromedioGeneral {
	 font-family:Verdana, Geneva, sans-serif;
	 font-size:14pt;
	 font-weight:bold;
	 color:#000;
	 font-weight:normal;
 }
 .TablaCalifPromedioTexto {
	 font-family:Verdana, Geneva, sans-serif;
	 font-size:9pt;
	 color:#000;
	 font-weight:normal;
 }
</style>

    </head>
    <body>
    <center><div class="SaltoDePagina">
        @foreach($clientes as $cliente)
        <table width="100%" class="Texto1">
            <tbody>
            <tr>
             <td width="21%" rowspan="3"><div align="center"><img src="" height="92"></div></td>
             <td width="79%" align="center"><div align="right" class="Texto1">GCEDVACE-001</div></td>
            </tr>
            <tr>
              <td align="center" valign="top"><span class="TITULO1">{{$cliente->plantel}}</span><br>
                <br>
                <br>
                <span class="textoACTAS3">Informe de Calificaciones</span></td>
              </tr>
            <tr>
              <td align="center" valign="top"><div align="right" class="menuNiv1">{{$cliente->id}}</div></td>
            </tr>
            </tbody>
            </table>
        
            <table width="100%" border="0" cellpadding="5" cellspacing="0" bordercolor="#FFFFFF" class="Texto1">
                <tbody>
                <tr>
                <td colspan="2"><div align="center" class="Texto1Negrita">Asignaturas</div></td>
                <td width="36%" rowspan="2" align="center" class="Texto1Negrita">Promedio General</td>   
                <td align="right">Ingreso:</td>
                <td width="143" align="left">{{$cliente->fec_inscripcion}}</td>
                </tr>
              <tr>
                <?php 
                    $materias=\App\Hacademica::where('cliente_id',$cliente->id)->where('lectivo_id',$cliente->lectivo)->get();
                    $aprobadas=0;
                    $no_aprobadas=0;
                    $total=0;
                    $promedio=0;
                    $suma=0;
                    //$cantidad_registros=0;
                    foreach($materias as $materia){
                        if($materia->st_materium_id==1){
                            $aprobada++;
                        }elseif($materia->st_materia_id==2){
                            $no_aprobadas++;
                        }
                        $total++;
                        foreach($materia->calificaciones as $calificacion){
                            $suma=$calificacion->calificacion+$suma;
                        }
                        
                    }    
                    $promedio=$suma/$total;
                ?>  
                <td width="136"><div align="right">Aprobadas: &nbsp;</div></td>
                <td width="54"><div align="center" class="Texto1Negrita">{{$aprobadas}}</div></td>
                <td align="right">Egreso:</td>
                <td align="left" class="Texto1Negrita"></td>
              </tr>
              <tr>
                <td><div align="right">No Aprobadas: &nbsp;</div></td>
                <td><div align="center" class="Texto1Negrita">{{$no_aprobadas}}</div></td>

                <td width="219" rowspan="3" align="center" class="PromedioGeneral">
                Modular: {{$promedio}}</td>

                <td align="right">Turno: </td>
                <td align="left" class="Texto1Negrita">{{$cliente->turno}}</td>
                </tr>
              <tr>
                <td><div align="right">Sin Calificación: &nbsp;</div></td>
                <td><div align="center" class="Texto1Negrita">0</div></td>
                <td align="right">Horario: </td>
                <td align="left" class="Texto1Negrita">{{$cliente->turno}}</td>
                </tr>
              <tr>
                <td><div align="right">Total: &nbsp;</div></td>
                <td><div align="center" class="Texto1Negrita">{{$total}}</div></td>
                <td align="right">Inasistencias:</td>
                <?php 
                $inasistencias= \App\AsistenciaR::where('asignacion_academica_id',$datos['asignacion'])
                                                 ->where('est_asistencia_id',2)
                                                 ->where('cliente_id',$cliente->id)
                                                 ->count();
                ?>
                <td><div align="center" class="Texto1Negrita">{{$inasistencias}}</div></td>
              </tr>
              </tbody>
            </table>
            <table cellpadding="2" cellspacing="0" border="1" width="700">
                <tbody>
                    <tr class="TablaCalifTitulo">
                        <td colspan="4">{{$cliente->grado}}</td>
                    </tr>
                    <tr class="TablaCalifTitulo">
                        <td rowspan="2" align="center">#</td>
                        <td rowspan="2">Materia</td>
                        <td colspan="1">Calificaciones</td>
                        <td rowspan="2">Promedio</td>
                    </tr>
                    <tr class="TablaCalifTitulo">
                        <td>1ERO</td>
                    </tr>
                    <?php $i=0; ?>
                    @foreach($materias as $materia){
                    <?php $i++; ?>
                    <tr class="TablaCalifTexto">
                        <td class="TablaCalifTexto2" align="center">{{$i}}</td>
                        <td>{{$materia->materia->name}}</td>
                        <td align="center">{{}}</td>
                        <td align="center">8.5</td>
                    </tr>
                    @endforeach
                </tbody></table>
            <table width="95%" border="0" cellpadding="10" cellspacing="0" bordercolor="#FFFFFF" class="Texto1" align="center">
                <tbody><tr>
                      <td align="center" valign="bottom" height="100"><span style="font-weight: bold">______________________________________</span><br>
                              SERGIO NARVAEZ DURAN<br>
                              DIRECTOR DE LA CARRERA</td> 
                      <td align="center" valign="bottom" height="100">&nbsp;</td> 
                      <td align="center" valign="bottom" height="100"><span style="font-weight: bold">______________________________________</span><br>
                              JOSE FRANCISCO PEREZ AGUILAR<br>
                              INSTRUCTOR DEL AREA</td> 
                </tr>
                </tbody>
            </table>    
            <table width="95%" border="1" cellpadding="10" cellspacing="0" bordercolor="#CCCCCC" class="Texto1" align="center">
                <tbody><tr>
                 <td width="68%" bordercolor="#FFFFFF"><div align="center" class="textoACTAS3">CONTROL DE BOLETAS ENTREGADAS</div></td>
                 <td width="32%" bordercolor="#FFFFFF"><div align="center">Folio N°<span style="font-weight: bold">301A001-13002-1</span></div></td>
                </tr>
                <tr>
                  <td colspan="2" bordercolor="#FFFFFF"><p>Promedio  general evaluatorio entregado a: <span style="font-weight: bold">ADAYA  DIAZ  EDUARDO HELI</span>, que acredita  tanto su conocimiento, habilidades y destrezas adquiridas en el modulo <u>SISTEMA ELECTRICO</u> (Técnico Mecánico de Motocicletas). 
                    <strong>PROMEDIO GENERAL MODULAR: 8.5</strong>    
                   </p></td>
                  </tr>
                <tr>
                  <td colspan="2" bordercolor="#FFFFFF">Del ciclo escolar correspondiente: Marzo 2013.</td>
                  </tr>
                <tr>
                  <td height="70" align="center" valign="bottom" bordercolor="#FFFFFF"><strong>____________________________________________________</strong><br>
                    Nombre y firma del alumno (enterado y de conformidad)</td>
                  <td align="center" valign="bottom" bordercolor="#FFFFFF"><br>
              <br>

                    Huella</td>
                </tr>
                </tbody>
            </table>
        @endforeach
        
        </di></center>
        <script type="text/php">
            /*if (isset($pdf))
            {
            $font = Font_Metrics::get_font("Arial", "bold");
            $pdf->page_text(670, 580, "Pagina {PAGE_NUM} de {PAGE_COUNT}", $font, 9, array(0, 0, 0));
            }*/
        </script>
    </body>
</html>

