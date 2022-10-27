@extends('plantillas.admin_template')

@include('prospectoTareas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('prospectoTareas.index') }}">@yield('prospectoTareasAppTitle')</a></li>
	    <li><a href="{{ route('prospectoTareas.show', $prospectoTarea->id) }}">{{ $prospectoTarea->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('prospectoTareasAppTitle') / Editar {{$prospectoTarea->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($prospectoTarea, array('route' => array('prospectoTareas.update', $prospectoTarea->id),'method' => 'post')) !!}

@include('prospectoTareas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('prospectoTareas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection