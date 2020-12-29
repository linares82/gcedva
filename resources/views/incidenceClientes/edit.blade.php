@extends('plantillas.admin_template')

@include('incidenceClientes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('incidenceClientes.index') }}">@yield('incidenceClientesAppTitle')</a></li>
	    <li><a href="{{ route('incidenceClientes.show', $incidenceCliente->id) }}">{{ $incidenceCliente->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('incidenceClientesAppTitle') / Editar {{$incidenceCliente->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($incidenceCliente, array('route' => array('incidenceClientes.update', $incidenceCliente->id),'method' => 'post')) !!}

@include('incidenceClientes._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('incidenceClientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection