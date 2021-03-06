@extends('plantillas.admin_template')

@include('hAsistenciaRs._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('hAsistenciaRs.index') }}">@yield('hAsistenciaRsAppTitle')</a></li>
	    <li><a href="{{ route('hAsistenciaRs.show', $hAsistenciaR->id) }}">{{ $hAsistenciaR->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('hAsistenciaRsAppTitle') / Editar {{$hAsistenciaR->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($hAsistenciaR, array('route' => array('hAsistenciaRs.update', $hAsistenciaR->id),'method' => 'post')) !!}

@include('hAsistenciaRs._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('hAsistenciaRs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection