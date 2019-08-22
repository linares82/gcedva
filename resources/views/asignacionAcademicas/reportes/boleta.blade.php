<html>
  <head>
      <style>
        h1, h3, h5, th { text-align: center; }
        body{
           font-family: Arial;
           font-size: 1em;
        }
        
        
        .table_format {
            border: 1px solid #ddd;
            font-size: 1em;
            border-collapse: collapse;
        }
        
        .table_format2 {
            border: 1px solid #ddd;
            font-size: 1em;
            border-collapse: collapse;
            margin: 10px auto;
        }
        
        .table_format td {
            border: 1px solid #ddd;
            font-size: 1em;
            border-collapse: collapse;
            text-align: center;
        }
        
        .table_format th {
            border: 1px solid #ddd;
            font-size: 1em;
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
        <table width="100%">
            <td> <img src="{{ asset('storage/especialidads/'.$c->imagen) }}" alt="Sin logo" height="80px" ></img></td>
            <td> {{$cliente->plantel->razon}} <br/> Informe de Calificaciones </td>
        </table>
        <table width="100%">
            <tr>
                <td> Nombre: {{$cliente->nombre." ".$cliente->nombre2." ".$cliente->ape_paterno." ".$cliente->ape_materno}}</td>
                <td>Fecha Impresion:{{Date('d-m-Y')}}</td>
            </tr>
            <tr>
                <td colspan="3">Plantel:{{$cliente->plantel->razon}}</td>
                
            </tr>
        </table>
        @foreach($cliente->inscripciones as $i)
            <table width="100%" class='table_format'>
                <thead>
                <th>Especialidad</th><th>Nivel</th>
                <th>Grado</th><th>Grupo</th><th>Periodo</th><th>F. Inscripcion</th>
                <th>Periodo Lectivo</th>
                <th>Matricula</th>
                </thead>
                <tbody>

                    <tr>
                        <td>{{$i->especialidad->name}}</td>
                        <td>{{$i->nivel->name}}</td>
                        <td>{{$i->grado->name}}</td>
                        <td>{{$i->grupo->name}}</td>
                        <td>{{$i->periodo_estudio->name}}</td>
                        <td>{{$i->fec_inscripcion}}</td>
                        <td>{{$i->lectivo->name}}</td>
                        <td>{{$i->matricula}}</td>
                    </tr>
                    <tr>
                        <td colspan='8'>
                    <table class='table_format' width='100%'>
                        <thead>
                        <th colspan='8'>Materias</th>
                        </thead>
                        <tbody>
                            @foreach($i->hacademicas as $a)
                            <tr>
                                <td colspan='3'>{{$a->materia->name}}</td>

                                <td colspan="5">
                                    <table class='table_format' width='100%'>

                                        <tbody>
                                            @foreach($a->calificaciones as $cali)
                                            <tr>

                                                <tr>    
                                                    <strong>Tipo de examen:{{$cali->tpoExamen->name}} - </strong>
                                                    @foreach($cali->calificacionPonderacions as $calificacionPonderacion)
                                                        <th class="centrar_texto">{{$calificacionPonderacion->cargaPonderacion->name}}</th>
                                                    @endforeach
                                                </tr>
                                                <tr>
                                                    <strong>Calificación: {{$cali->calificacion}}</strong>
                                                    @foreach($cali->calificacionPonderacions as $calificacionPonderacion)
                                                        <td class="centrar_texto">{{$calificacionPonderacion->calificacion_parcial}}</td>
                                                    @endforeach
                                                </tr>
                                            <tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        </tbody>
                        </tr>

                        </tbody>
                    </table>
                            </td>
                @endforeach
                
                <table width='500px' class='table_format table_format2'>
                    <tr><td><br/><br/><br/><br/><br/><br/><br/><br/><br/></td><td ></td></tr>
                    <tr><td ></td><td ></td></tr>
                    <tr><td>Director de Carrera</td><td>Instructor del Area</td></tr>
                </table
                
                <table width="95%" class="table_format">
                    <tbody><tr>
                     <td width="68%" bordercolor="#FFFFFF"><div align="center" class="textoACTAS3">CONTROL DE BOLETAS ENTREGADAS</div></td>
                     <td width="32%" bordercolor="#FFFFFF"><div align="center"><span style="font-weight: bold"></span></div></td>
                    </tr>
                    <tr>
                      <td colspan="2" bordercolor="#FFFFFF"><p>Promedio  general evaluatorio entregado a: <span style="font-weight: bold">{{$cliente->nombre." ".$cliente->nombre2." ".$cliente->ape_paterno." ".$cliente->ape_materno}}</span>, que acredita  tanto su conocimiento, habilidades y destrezas adquiridas en <u>{{$i->grado->name}}</u> 
                        
                       </p></td>
                      </tr>
                    <tr>
                      <td colspan="2" bordercolor="#FFFFFF">Del ciclo escolar correspondiente: {{$i->lectivo->name}}.</td>
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
            </div>
        @endforeach        
    
    
  </body>
</html>