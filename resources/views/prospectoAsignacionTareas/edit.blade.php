@extends('plantillas.admin_template')

@include('prospectoAsignacionTareas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('prospectoAsignacionTareas.index') }}">@yield('prospectoAsignacionTareasAppTitle')</a></li>
	    <li><a href="{{ route('prospectoAsignacionTareas.show', $prospectoAsignacionTarea->id) }}">{{ $prospectoAsignacionTarea->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('prospectoAsignacionTareasAppTitle') / Editar {{$prospectoAsignacionTarea->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($prospectoAsignacionTarea, array('route' => array('prospectoAsignacionTareas.update', $prospectoAsignacionTarea->id),'method' => 'post')) !!}

@include('prospectoAsignacionTareas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('prospectoAsignacionTareas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection