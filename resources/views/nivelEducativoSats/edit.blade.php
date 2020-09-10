@extends('plantillas.admin_template')

@include('nivelEducativoSats._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('nivelEducativoSats.index') }}">@yield('nivelEducativoSatsAppTitle')</a></li>
	    <li><a href="{{ route('nivelEducativoSats.show', $nivelEducativoSat->id) }}">{{ $nivelEducativoSat->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('nivelEducativoSatsAppTitle') / Editar {{$nivelEducativoSat->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($nivelEducativoSat, array('route' => array('nivelEducativoSats.update', $nivelEducativoSat->id),'method' => 'post')) !!}

@include('nivelEducativoSats._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('nivelEducativoSats.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection