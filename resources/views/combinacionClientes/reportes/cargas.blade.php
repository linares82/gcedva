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
    
    <link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"
      integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ=="
      crossorigin="anonymous">
    
  </head>
  <body style="padding:10px;">
    <div class="datagrid">
        <h3>Consulta de Carga de registros</h3>
        <select id="seleccion">
            <option value="0">Seleccionar Opción</option>
            <option value="1">Planteles</option>
            <option value="2">Especialidades</option>
            <option value="3">Niveles</option>
            <option value="4">Grados</option>
            <option value="5">Grupos</option>
            <option value="6">Turnos</option>
            <option value="7">Asignaciones</option>
            <option value="8">Materias</option>
        </select>
        <div class="row"></div>
        {!! Form::open(array('route' => 'plantels.listaPlanteles', 'id'=>"frm_planteles")) !!}
            {!! Form::select("plantel[]", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Ver</button>
            </div>
        {!! Form::close() !!}

        {!! Form::open(array('route' => 'especialidads.listaEspecialidades', 'id'=>"frm_especialidades")) !!}
        <form method="post" id="frm_especialidades" action="{{route('especialidads.listaEspecialidades')}}">
            {!! Form::select("plantel[]", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Ver</button>
            </div>
        {!! Form::close() !!}

        {!! Form::open(array('route' => 'nivels.listaNiveles', 'id'=>"frm_niveles")) !!}
        
            {!! Form::select("plantel[]", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Ver</button>
            </div>
            {!! Form::close() !!}

            {!! Form::open(array('route' => 'grados.listaGrados', 'id'=>"frm_grados")) !!}
        
            {!! Form::select("plantel[]", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Ver</button>
            </div>
        </form>

        {!! Form::open(array('route' => 'grupos.listaGrupos', 'id'=>"frm_grupos")) !!}
        
            {!! Form::select("plantel[]", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Ver</button>
            </div>
            {!! Form::close() !!}

            {!! Form::open(array('route' => 'turnos.listaTurnos', 'id'=>"frm_turnos")) !!}
        
            {!! Form::select("plantel[]", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Ver</button>
            </div>
            {!! Form::close() !!}

            {!! Form::open(array('route' => 'asignacionAcademica.listaAsignaciones', 'id'=>"frm_asignaciones")) !!}
    
            {!! Form::select("plantel[]", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Ver</button>
            </div>
            {!! Form::close() !!}

            {!! Form::open(array('route' => 'grupos.listaMateriasXGrupo', 'id'=>"frm_materias")) !!}
        
            {!! Form::select("plantel[]", $plantels, null, array("class" => "form-control select_seguridad", "id" => "plantel_f-field", 'multiple'=>true)) !!}
            <div class="well well-sm">
                <button type="submit" class="btn btn-primary">Ver</button>
            </div>
            {!! Form::close() !!}
            <!--
        <a href="{{route('plantels.listaPlanteles')}}" class="btn btn-md btn-success">Planteles</a>
        <a href="{{route('especialidads.listaEspecialidades')}}" class="btn btn-md btn-success">Especialidades</a>
        <a href="{{route('nivels.listaNiveles')}}" class="btn btn-md btn-success">Niveles</a>
        <a href="{{route('grados.listaGrados')}}" class="btn btn-md btn-success">Grados</a>
        <a href="{{route('grupos.listaGrupos')}}" class="btn btn-md btn-success">Grupos</a>
        <a href="{{route('turnos.listaTurnos')}}" class="btn btn-md btn-success">Turnos</a>
        <a href="{{route('asignacionAcademica.listaAsignaciones')}}" class="btn btn-md btn-success">Asignaciones</a>
        <a href="{{route('grupos.listaMateriasXGrupo')}}" class="btn btn-md btn-success">Materias por Grupo</a>
            -->
        @if(isset($planteles))
        <table class="table table-condensed table-striped">
            <thead>
                <th>Id</th><th>Razon</th><th>RFC</th><th>Cve. Incorporacion</th><th>Tel.</th><th>Mail</th><th>Pag Web</th>
                <th>logo</th><th>Slogan</th><th>Membrete</th><th>Tipo Plantel</th>
            </thead>
            <tbody>
            
                @foreach($planteles as $plantel)
                <tr>
                <td>{{$plantel->id}}</td><td>{{$plantel->razon}}</td><td>{{$plantel->rfc}}</td><td>{{$plantel->cve_incorporacion}}</td>
                <td>{{$plantel->tel}}</td><td>{{$plantel->mail}}</td><td>{{$plantel->pag_web}}</td><td>{{$plantel->logo}}</td>
                <td>{{$plantel->slogan}}</td><td>{{$plantel->membrete}}</td><td>{{$plantel->tpo_plantel->name}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        @endif

        @if(isset($especialidades))
        <table class="table table-condensed table-striped">
            <thead>
                <th>Id </th><th>Plantel</th><th>Id</th><th>Especialidad</th><th>RVOE</th><th>Vencimiento RVOE</th><th>CCT</th>
                <th>Meta</th><th>Imagen</th><th>Abreviatura</th><th>Fondo Credencial</th>
            </thead>
            <tbody>
            
                @foreach($especialidades as $especialidad)
                <tr>
                    <td>{{ $especialidad->plantel_id }}</td><td>{{optional($especialidad->plantel)->razon}}</td><td>{{$especialidad->id}}</td><td>{{$especialidad->name}}</td><td>{{$especialidad->rvoe}}</td><td>{{$especialidad->vencimiento_rvoe}}</td>
                <td>{{$especialidad->ccte}}</td><td>{{$especialidad->meta}}</td><td>{{$especialidad->imagen}}</td>
                <td>{{$especialidad->abreviatura}}</td><td>{{$especialidad->fondo_credencial}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        @endif

        @if(isset($niveles))
        <table class="table table-condensed table-striped">
            <thead>
                <th>Id</th><th>Plantel</th><th>Id</th><th>Especialidad</th><th>Id</th><th>Nivel</th>
            </thead>
            <tbody>
            
                @foreach($niveles as $nivel)
                <tr>
                    <td>{{$nivel->plantel_id}}</td><td>{{$nivel->plantel->razon}}</td><td>{{ $nivel->especialidad_id }}</td><td>{{$nivel->especialidad->name}}</td><td>{{$nivel->id}}</td><td>{{$nivel->name}}</td>
                
                </tr>
                @endforeach
                
            </tbody>
        </table>
        @endif

        @if(isset($grados))
        <table class="table table-condensed table-striped">
            <thead>
                <td>Id</td><th>Plantel</th><td>Id</td><th>Especialidad</th><td>Id</td><th>Nivel</th><th>Id</th><th>Grado</th>
            </thead>
            <tbody>
            
                @foreach($grados as $grado)
                <tr><td>{{ $grado->plantel_id }}</td>
                    <td>{{optional($grado->plantel)->razon}}</td>
                    <td>{{ $grado->especialidad_id }}</td><td>{{optional($grado->especialidad)->name}}</td>
                    <td>{{ $grado->nivel_id }}</td><td>{{optional($grado->nivel)->name}}</td>
                    <td>{{$grado->id}}</td><td>{{$grado->name}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        @endif

        @if(isset($grupos))
        <table class="table table-condensed table-striped">
            <thead>
                <th>Id</th><th>Grupo</th><th>Desc. Corta</th><th>Plantel</th><th>Salon</th>
            </thead>
            <tbody>
            
                @foreach($grupos as $grupo)
                <tr>
                    <td>{{optional($grupo->plantel)->razon}}</td><td>{{$grupo->id}}</td><td>{{$grupo->name}}</td><td>{{$grupo->desc_corta}}</td>
                <td>{{optional($grupo->salon)->name}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        @endif

        @if(isset($turnos))
        <table class="table table-condensed table-striped">
            <thead>
                <th>Id</th>
                <th>Plantel</th><th>Id</th><th>Especialidad</th><th>Id</th><th>Nivel</th><th>Id</th><th>Grado</th><th>Id</th><th>Turno</th><th>Plan Pagos</th>
            </thead>
            <tbody>
            
                @foreach($turnos as $turno)
                <tr>
                    <td>{{ $turno->plantel_id }}</td><td>{{optional($turno->plantel)->razon}}</td>
                    <td>{{ $turno->especialidad_id }}</td><td>{{optional($turno->especialidad)->name}}</td>
                    <td>{{ $turno->nivel_id }}</td><td>{{optional($turno->nivel)->name}}</td>
                    <td>{{ $turno->grado_id }}</td><td>{{optional($turno->grado)->name}}</td>
                    <td>{{$turno->id}}</td><td>{{$turno->name}}</td>
                    <td>
                    @foreach($turno->planes as $plan)
                    {{$plan->name}} <br>
                    @endforeach
                </td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        @endif

        @if(isset($asignaciones))
        <table class="table table-condensed table-striped">
            <thead>
                <th>Id Asignacion</th><th>Docente ID</th><th>Docente</th>
                <th>Materia ID</th><th>Materia</th>
                <th>Grupo Id</th><th>Grupo</th>
                <th>Plantel Id</th><th>Plantel</th>
                <th>Lectivo Id</th><th>Lectivo</th>
                <th>D. Oficial Id</th><th>D. Oficial</th>
                <th>L. Oficial Id</th><th>L. Oficial</th>

            </thead>
            <tbody>
                @foreach($asignaciones as $asignacion)
                <tr>
                    <td>{{ $asignacion->asignacion_id }}</td><td>{{ $asignacion->d_id }}</td>
                    <td>{{ $asignacion->d_nombre }} {{ $asignacion->d_ape_paterno }} {{ $asignacion->d_ape_materno }}</td>
                    <td>{{ $asignacion->materia_id }}</td><td>{{ $asignacion->materia }}</td>
                    <td>{{ $asignacion->grupo_id }}</td><td>{{ $asignacion->grupo }}</td>
                    <td>{{ $asignacion->plantel_id }}</td><td>{{ $asignacion->razon }}</td>
                    <td>{{ $asignacion->lectivo_id }}</td><td>{{ $asignacion->lectivo }}</td>
                    <td>{{ $asignacion->do_id }}</td>
                    <td>{{ $asignacion->do_nombre }} {{ $asignacion->do_ape_aterno }} {{ $asignacion->do_ape_paterno }}</td>
                    <td>{{ $asignacion->lo_id }}</td><td>{{ $asignacion->lo_name }}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        @endif

        @if(isset($lista))
        <table class="table table-condensed table-striped">
            <thead>
                <th>Plantel Id</th><th>Plantel</th>
                <th>Grupo Id</th><th>Grupo</th>
                <th>Periodo Estudio Id</th><th>Periodo Estudio</th>
                <th>Plan Estudio Id</th><th>Plan Estudio</th>
                <th>Materia Id</th><th>Materia</th>
                <th>Ponderacion Id</th><th>Ponderacion</th>
            </thead>
            <tbody>
                @foreach($lista as $item)
                <tr>
                    <td>{{ $item->plantel_id }}</td><td>{{ $item->razon }}</td>
                    <td>{{ $item->grupo_id }}</td><td>{{ $item->grupo }}</td>
                    <td>{{ $item->periodo_estudio_id }}</td><td>{{ $item->periodo_estudio }}</td>
                    <td>{{ $item->plan_estudio_id }}</td><td>{{ $item->plan_estudio }}</td>
                    <td>{{ $item->materia_id }}</td><td>{{ $item->materia }}</td>
                    <td>{{ $item->ponderacion_id }}</td><td>{{ $item->ponderacion }}</td>
                    
                </tr>
                @endforeach
                
            </tbody>
        </table>
        @endif
    </div>
    <script>
        document.getElementById('frm_planteles').style.display = 'none';
                document.getElementById('frm_especialidades').style.display = 'none';
                document.getElementById('frm_niveles').style.display = 'none';
                document.getElementById('frm_grados').style.display = 'none';
                document.getElementById('frm_grupos').style.display = 'none';
                document.getElementById('frm_turnos').style.display = 'none';
                document.getElementById('frm_asignaciones').style.display = 'none';
                document.getElementById('frm_materias').style.display = 'none';
        var seleccion=document.getElementById('seleccion');
        //console.log(seleccion.options[seleccion.selectedIndex].value);
        seleccion.addEventListener('change', (event) => {
            //console.log();
            opcion=seleccion.options[seleccion.selectedIndex].value;
            if(opcion==1){
                document.getElementById('frm_planteles').style.display = 'block';
                document.getElementById('frm_especialidades').style.display = 'none';
                document.getElementById('frm_niveles').style.display = 'none';
                document.getElementById('frm_grados').style.display = 'none';
                document.getElementById('frm_grupos').style.display = 'none';
                document.getElementById('frm_turnos').style.display = 'none';
                document.getElementById('frm_asignaciones').style.display = 'none';
                document.getElementById('frm_materias').style.display = 'none';
            }else if(opcion==2){
                document.getElementById('frm_planteles').style.display = 'none';
                document.getElementById('frm_especialidades').style.display = 'block';
                document.getElementById('frm_niveles').style.display = 'none';
                document.getElementById('frm_grados').style.display = 'none';
                document.getElementById('frm_grupos').style.display = 'none';
                document.getElementById('frm_turnos').style.display = 'none';
                document.getElementById('frm_asignaciones').style.display = 'none';
                document.getElementById('frm_materias').style.display = 'none';
            }else if(opcion==3){
                document.getElementById('frm_planteles').style.display = 'none';
                document.getElementById('frm_especialidades').style.display = 'none';
                document.getElementById('frm_niveles').style.display = 'block';
                document.getElementById('frm_grados').style.display = 'none';
                document.getElementById('frm_grupos').style.display = 'none';
                document.getElementById('frm_turnos').style.display = 'none';
                document.getElementById('frm_asignaciones').style.display = 'none';
                document.getElementById('frm_materias').style.display = 'none';
            }else if(opcion==4){
                document.getElementById('frm_planteles').style.display = 'none';
                document.getElementById('frm_especialidades').style.display = 'none';
                document.getElementById('frm_niveles').style.display = 'none';
                document.getElementById('frm_grados').style.display = 'block';
                document.getElementById('frm_grupos').style.display = 'none';
                document.getElementById('frm_turnos').style.display = 'none';
                document.getElementById('frm_asignaciones').style.display = 'none';
                document.getElementById('frm_materias').style.display = 'none';
            }else if(opcion==5){
                document.getElementById('frm_planteles').style.display = 'none';
                document.getElementById('frm_especialidades').style.display = 'none';
                document.getElementById('frm_niveles').style.display = 'none';
                document.getElementById('frm_grados').style.display = 'none';
                document.getElementById('frm_grupos').style.display = 'block';
                document.getElementById('frm_turnos').style.display = 'none';
                document.getElementById('frm_asignaciones').style.display = 'none';
                document.getElementById('frm_materias').style.display = 'none';
            }else if(opcion==6){
                document.getElementById('frm_planteles').style.display = 'none';
                document.getElementById('frm_especialidades').style.display = 'none';
                document.getElementById('frm_niveles').style.display = 'none';
                document.getElementById('frm_grados').style.display = 'none';
                document.getElementById('frm_grupos').style.display = 'none';
                document.getElementById('frm_turnos').style.display = 'block';
                document.getElementById('frm_asignaciones').style.display = 'none';
                document.getElementById('frm_materias').style.display = 'none';
            }else if(opcion==7){
                document.getElementById('frm_planteles').style.display = 'none';
                document.getElementById('frm_especialidades').style.display = 'none';
                document.getElementById('frm_niveles').style.display = 'none';
                document.getElementById('frm_grados').style.display = 'none';
                document.getElementById('frm_grupos').style.display = 'none';
                document.getElementById('frm_turnos').style.display = 'none';
                document.getElementById('frm_asignaciones').style.display = 'block';
                document.getElementById('frm_materias').style.display = 'none';
            }else if(opcion==8){
                document.getElementById('frm_planteles').style.display = 'none';
                document.getElementById('frm_especialidades').style.display = 'none';
                document.getElementById('frm_niveles').style.display = 'none';
                document.getElementById('frm_grados').style.display = 'none';
                document.getElementById('frm_grupos').style.display = 'none';
                document.getElementById('frm_turnos').style.display = 'none';
                document.getElementById('frm_asignaciones').style.display = 'none';
                document.getElementById('frm_materias').style.display = 'block';
            }
        });

    </script>
    
  </body>
</html>
