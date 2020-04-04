@extends('plantillas.admin_template')

@include('bandejaAdjuntos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('bandejaAdjuntos.index') }}">@yield('bandejaAdjuntosAppTitle')</a></li>
	    <li><a href="{{ route('bandejaAdjuntos.show', $bandejaAdjunto->id) }}">{{ $bandejaAdjunto->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('bandejaAdjuntosAppTitle') / Editar {{$bandejaAdjunto->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($bandejaAdjunto, array('route' => array('bandejaAdjuntos.update', $bandejaAdjunto->id),'method' => 'post')) !!}

@include('bandejaAdjuntos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('bandejaAdjuntos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection