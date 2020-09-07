@extends('plantillas.admin_template')

@include('tipoPersonas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('tipoPersonas.index') }}">@yield('tipoPersonasAppTitle')</a></li>
	    <li><a href="{{ route('tipoPersonas.show', $tipoPersona->id) }}">{{ $tipoPersona->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('tipoPersonasAppTitle') / Editar {{$tipoPersona->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($tipoPersona, array('route' => array('tipoPersonas.update', $tipoPersona->id),'method' => 'post')) !!}

@include('tipoPersonas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('tipoPersonas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection