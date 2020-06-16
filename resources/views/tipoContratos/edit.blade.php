@extends('plantillas.admin_template')

@include('tipoContratos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('tipoContratos.index') }}">@yield('tipoContratosAppTitle')</a></li>
	    <li><a href="{{ route('tipoContratos.show', $tipoContrato->id) }}">{{ $tipoContrato->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('tipoContratosAppTitle') / Editar {{$tipoContrato->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($tipoContrato, array('route' => array('tipoContratos.update', $tipoContrato->id),'method' => 'post')) !!}

@include('tipoContratos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('tipoContratos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection