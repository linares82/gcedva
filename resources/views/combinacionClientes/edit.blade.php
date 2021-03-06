@extends('plantillas.admin_template')

@include('combinacionClientes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('combinacionClientes.index') }}">@yield('combinacionClientesAppTitle')</a></li>
	    <li><a href="{{ route('combinacionClientes.show', $combinacionCliente->id) }}">{{ $combinacionCliente->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('combinacionClientesAppTitle') / Editar {{$combinacionCliente->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($combinacionCliente, array('route' => array('combinacionClientes.update', $combinacionCliente->id),'method' => 'post')) !!}

@include('combinacionClientes._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('combinacionClientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection