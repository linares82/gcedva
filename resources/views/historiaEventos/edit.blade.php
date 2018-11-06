@extends('plantillas.admin_template')

@include('historiaEventos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('historiaEventos.index') }}">@yield('historiaEventosAppTitle')</a></li>
	    <li><a href="{{ route('historiaEventos.show', $historiaEvento->id) }}">{{ $historiaEvento->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('historiaEventosAppTitle') / Editar {{$historiaEvento->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($historiaEvento, array('route' => array('historiaEventos.update', $historiaEvento->id),'method' => 'post')) !!}

@include('historiaEventos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('historiaEventos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection