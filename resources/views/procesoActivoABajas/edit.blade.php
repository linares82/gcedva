@extends('plantillas.admin_template')

@include('procesoActivoABajas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('procesoActivoABajas.index') }}">@yield('procesoActivoABajasAppTitle')</a></li>
	    <li><a href="{{ route('procesoActivoABajas.show', $procesoActivoABaja->id) }}">{{ $procesoActivoABaja->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('procesoActivoABajasAppTitle') / Editar {{$procesoActivoABaja->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($procesoActivoABaja, array('route' => array('procesoActivoABajas.update', $procesoActivoABaja->id),'method' => 'post')) !!}

@include('procesoActivoABajas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('procesoActivoABajas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection