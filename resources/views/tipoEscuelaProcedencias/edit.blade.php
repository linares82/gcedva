@extends('plantillas.admin_template')

@include('tipoEscuelaProcedencias._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('tipoEscuelaProcedencias.index') }}">@yield('tipoEscuelaProcedenciasAppTitle')</a></li>
	    <li><a href="{{ route('tipoEscuelaProcedencias.show', $tipoEscuelaProcedencium->id) }}">{{ $tipoEscuelaProcedencium->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('tipoEscuelaProcedenciasAppTitle') / Editar {{$tipoEscuelaProcedencium->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($tipoEscuelaProcedencium, array('route' => array('tipoEscuelaProcedencias.update', $tipoEscuelaProcedencium->id),'method' => 'post')) !!}

@include('tipoEscuelaProcedencias._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('tipoEscuelaProcedencias.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection