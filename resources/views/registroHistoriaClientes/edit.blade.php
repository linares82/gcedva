@extends('plantillas.admin_template')

@include('registroHistoriaClientes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('registroHistoriaClientes.index') }}">@yield('registroHistoriaClientesAppTitle')</a></li>
	    <li><a href="{{ route('registroHistoriaClientes.show', $registroHistoriaCliente->id) }}">{{ $registroHistoriaCliente->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('registroHistoriaClientesAppTitle') / Editar {{$registroHistoriaCliente->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($registroHistoriaCliente, array('route' => array('registroHistoriaClientes.update', $registroHistoriaCliente->id),'method' => 'post')) !!}

@include('registroHistoriaClientes._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('registroHistoriaClientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection