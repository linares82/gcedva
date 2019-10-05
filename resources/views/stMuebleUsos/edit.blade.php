@extends('plantillas.admin_template')

@include('stMuebleUsos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('stMuebleUsos.index') }}">@yield('stMuebleUsosAppTitle')</a></li>
	    <li><a href="{{ route('stMuebleUsos.show', $stMuebleUso->id) }}">{{ $stMuebleUso->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('stMuebleUsosAppTitle') / Editar {{$stMuebleUso->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($stMuebleUso, array('route' => array('stMuebleUsos.update', $stMuebleUso->id),'method' => 'post')) !!}

@include('stMuebleUsos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('stMuebleUsos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection