@extends('plantillas.admin_template')

@include('inscripcions._common')

@section('header')

    <ol class="breadcrumb">
    	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
        <!--
        @if ( $query_params = Request::input('q') )

            <li class="active"><a href="{{ route('inscripcions.index') }}">@yield('inscripcionsAppTitle')</a></li>
            <li class="active">condition(  

            @foreach( $query_params as $key => $value )
                @if (!$loop->first) / @endif {{ $key }} : {{ $value }}
            @endforeach
            )</li>
        @else
            <li class="active">@yield('inscripcionsAppTitle')</li>
        @endif
        -->
        <li class="active">@yield('inscripcionsAppTitle')</li>
    </ol>

    <div class="">
        <h3>
            <i class="glyphicon glyphicon-align-justify"></i> @yield('inscripcionsAppTitle')
            @permission('inscripcions.create')
            <!--<a class="btn btn-success pull-right" href="{{ route('inscripcions.create') }}"><i class="glyphicon glyphicon-plus"></i> Crear</a>-->
            @endpermission
        </h3>

    </div>

    

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-condensed table-striped">
                <thead>
                    <th>Plantel</th><th>Especialidad</th><th>Nivel</th><th>Grado</th><th>Grupo</th>
                <th>P. Estudio</th><th>Lectivo</th>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $inscripcion->plantel->razon }}</td><td>{{ $inscripcion->especialidad->name }}</td>
                        <td>{{ $inscripcion->nivel->name }}</td><td>{{ $inscripcion->grado->name }}</td>
                        <td>{{ $inscripcion->grupo->name }}</td><td>{{ $inscripcion->periodo_estudio->name }}</td>
                        <td>{{ $inscripcion->lectivo->name }}</td><td></td><td></td>
                    </tr>
                </tbody>
                
            </table>
            @if($inscripcions->count())
            {!! Form::open(array('route' => 'inscripcions.cargarMaterias')) !!}
            <h4>Alumnos</h4> <button type="submit" class="btn btn-primary">Registrar Materias</button>
            <table class="table table-condensed table-striped">
                    <thead>
                        <th>No.</th><th>Nombre</th><th>Materias</th>
                    </thead>
                    <tbody>
                        @foreach($inscripcions as $i)
                        <tr>
                            <td>
                                {{ ++$no  }}
                                {!! Form::hidden("insc[]", $i->id, array("class" => "form-control input-sm")) !!}
                            </td>
                            <td>
                                <a href="{{ route('clientes.edit',$i->cliente_id) }}" target="_blank">
                                 {{ $i->cliente_id }} - {{ $i->cliente->nombre }} {{ $i->cliente->nombre2 }} {{ $i->cliente->ape_paterno }} {{ $i->cliente->ape_materno }}
                                </a>
                            </td>
                            <td>{{ $i->hacademicas->count() }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            {!! Form::close() !!}    
            @else
                <h3 class="text-center alert alert-info">Vacio!</h3>
            @endif

        </div>
    </div>

@endsection