@extends('plantillas.admin_template')

@include('empresasVinculacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('empresasVinculacions.index') }}">@yield('empresasVinculacionsAppTitle')</a></li>
	    <li><a href="{{ route('empresasVinculacions.show', $empresasVinculacion->id) }}">{{ $empresasVinculacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('empresasVinculacionsAppTitle') / Editar {{$empresasVinculacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($empresasVinculacion, array('route' => array('empresasVinculacions.update', $empresasVinculacion->id),'method' => 'post')) !!}

@include('empresasVinculacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('empresasVinculacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection