<html>
  <head>
      <style>
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
    <div class="datagrid">
        <table width="100%">
            <td> <img src="{{ asset('/imagenes/planteles/'.$cliente->plantel_id."/".$cliente->plantel->logo) }}" alt="Sin logo" height="80px" ></img></td>
            <td> {{$cliente->plantel->razon}} <br/> Informe de Calificaciones </td>
        </table>
        <table width="100%">
            <tr>
                <td>Matricula:{{$cliente->matricula}}</td>
                <td> Nombre: {{$cliente->nombre." ".$cliente->nombre2." ".$cliente->ape_paterno." ".$cliente->ape_materno}}</td>
                <td>Fecha:</td>
            </tr>
            <tr>
                <td colspan="3">Plantel:{{$cliente->plantel->razon}}</td>
                
            </tr>
        </table>
        @foreach($cliente->inscripciones as $i)
            <table width="100%">
                <thead style="color: #ffffff;background: #0B0B3B;">
                <td>Especialidad</td><td>Nivel</td>
                <td>Grado</td><td>Grupo</td><td>Periodo</td><td>F. Inscripcion</td>
                <td>Periodo Lectivo</td>
                </thead>
                <tbody>

                    <tr style="color: #ffffff;background:#6495ED;">
                        <td>{{$i->especialidad->name}}</td>
                        <td>{{$i->nivel->name}}</td>
                        <td>{{$i->grado->name}}</td>
                        <td>{{$i->grupo->name}}</td>
                        <td>{{$i->periodo_estudio->name}}</td>
                        <td>{{$i->fec_inscripcion}}</td>
                        <td>{{$i->lectivo->name}}</td>
                        
                    </tr>
                    <tr>
                <table class="table table-condensed table-striped">
                    <thead style="color: #ffffff;background: #27ae60;">
                    <td>Materia</td><td></td><td></td>
                    </thead>
                    <tbody>
                        @foreach($i->hacademicas as $a)
                        <tr>
                            <td>{{$a->materia->name}}</td>
                            
                            <td colspan="2">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <td>Examen</td>
                                    
                                    <td>Calificación</td>
                                    </thead>
                                    <tbody>
                                        @foreach($a->calificaciones as $cali)
                                        <tr>
                                            
                                            <tr>    
                                                Tipo de examen:{{$cali->tpoExamen->name}} - 
                                                @foreach($cali->calificacionPonderacions as $calificacionPonderacion)
                                                    <td class="centrar_texto">{{$calificacionPonderacion->cargaPonderacion->name}}</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                Calificación: {{$cali->calificacion}}
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
                @endforeach
                
                <table class='blueTable'>
                    <tr class='td1'><td></td></tr>
                    <tr><td class='tdw'></td></tr>
                    <tr><td>Director de Carrera</td></tr>
                </table>
    </div>
    
  </body>
</html>
