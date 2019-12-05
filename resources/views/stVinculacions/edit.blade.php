@extends('plantillas.admin_template')

@include('stVinculacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('stVinculacions.index') }}">@yield('stVinculacionsAppTitle')</a></li>
	    <li><a href="{{ route('stVinculacions.show', $stVinculacion->id) }}">{{ $stVinculacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('stVinculacionsAppTitle') / Editar {{$stVinculacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($stVinculacion, array('route' => array('stVinculacions.update', $stVinculacion->id),'method' => 'post')) !!}

@include('stVinculacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('stVinculacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection