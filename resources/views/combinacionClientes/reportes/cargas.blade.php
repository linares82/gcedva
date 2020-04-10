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
        <a href="{{route('plantels.listaPlanteles')}}" class="btn btn-md btn-success">Planteles</a>
        <a href="{{route('especialidads.listaEspecialidades')}}" class="btn btn-md btn-success">Especialidades</a>
        <a href="{{route('nivels.listaNiveles')}}" class="btn btn-md btn-success">Niveles</a>
        <a href="{{route('grados.listaGrados')}}" class="btn btn-md btn-success">Grados</a>
        <a href="{{route('grupos.listaGrupos')}}" class="btn btn-md btn-success">Grupos</a>
        <a href="{{route('turnos.listaTurnos')}}" class="btn btn-md btn-success">Turnos</a>
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
                <th>Plantel</th><th>Id</th><th>Especialidad</th><th>RVOE</th><th>Vencimiento RVOE</th><th>CCT</th>
                <th>Meta</th><th>Imagen</th><th>Abreviatura</th><th>Fondo Credencial</th>
            </thead>
            <tbody>
            
                @foreach($especialidades as $especialidad)
                <tr>
                    <td>{{optional($especialidad->plantel)->razon}}</td><td>{{$especialidad->id}}</td><td>{{$especialidad->name}}</td><td>{{$especialidad->rvoe}}</td><td>{{$especialidad->vencimiento_rvoe}}</td>
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
                <th>Plantel</th><th>Especialidad</th><th>Id</th><th>Nivel</th>
            </thead>
            <tbody>
            
                @foreach($niveles as $nivel)
                <tr>
                    <td>{{$nivel->plantel->razon}}</td><td>{{$nivel->especialidad->name}}</td><td>{{$nivel->id}}</td><td>{{$nivel->name}}</td>
                
                </tr>
                @endforeach
                
            </tbody>
        </table>
        @endif

        @if(isset($grados))
        <table class="table table-condensed table-striped">
            <thead>
                <th>Plantel</th><th>Especialidad</th><th>Nivel</th><th>Id</th><th>Grado</th>
            </thead>
            <tbody>
            
                @foreach($grados as $grado)
                <tr>
                    <td>{{optional($grado->plantel)->razon}}</td>
                    <td>{{optional($grado->especialidad)->name}}</td><td>{{optional($grado->nivel)->name}}</td><td>{{$grado->id}}</td><td>{{$grado->name}}</td>
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
                    <td>{{ptional($grupo->plantel)->razon}}</td><td>{{$grupo->id}}</td><td>{{$grupo->name}}</td><td>{{$grupo->desc_corta}}</td>
                <td>{{optional($grupo->salon)->name}}</td>
                </tr>
                @endforeach
                
            </tbody>
        </table>
        @endif

        @if(isset($turnos))
        <table class="table table-condensed table-striped">
            <thead>
                <th>Plantel</th><th>Especialidad</th><th>Nivel</th><th>Grado</th><th>Id</th><th>Turno</th><th>Plan Pagos</th>
            </thead>
            <tbody>
            
                @foreach($turnos as $turno)
                <tr>
                    <td>{{optional($turno->plantel)->razon}}</td>
                <td>{{optional($turno->especialidad)->name}}</td><td>{{optional($turno->nivel)->name}}</td><td>{{optional($turno->grado)->name}}</td><td>{{$turno->id}}</td><td>{{$turno->name}}</td>
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
    </div>
    
  </body>
</html>
