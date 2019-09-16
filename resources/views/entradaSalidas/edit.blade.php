@extends('plantillas.admin_template')

@include('entradaSalidas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('entradaSalidas.index') }}">@yield('entradaSalidasAppTitle')</a></li>
	    <li><a href="{{ route('entradaSalidas.show', $entradaSalida->id) }}">{{ $entradaSalida->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('entradaSalidasAppTitle') / Editar {{$entradaSalida->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($entradaSalida, array('route' => array('entradaSalidas.update', $entradaSalida->id),'method' => 'post')) !!}

@include('entradaSalidas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('entradaSalidas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection