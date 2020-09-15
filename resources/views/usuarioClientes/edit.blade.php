@extends('plantillas.admin_template')

@include('usuarioClientes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('usuarioClientes.index') }}">@yield('usuarioClientesAppTitle')</a></li>
	    <li><a href="{{ route('usuarioClientes.show', $usuarioCliente->id) }}">{{ $usuarioCliente->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('usuarioClientesAppTitle') / Editar {{$usuarioCliente->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($usuarioCliente, array('route' => array('usuarioClientes.update', $usuarioCliente->id),'method' => 'post')) !!}

@include('usuarioClientes._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('usuarioClientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection