@extends('plantillas.admin_template')

@include('peridoExamens._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('peridoExamens.index') }}">@yield('peridoExamensAppTitle')</a></li>
	    <li><a href="{{ route('peridoExamens.show', $peridoExaman->id) }}">{{ $peridoExaman->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('peridoExamensAppTitle') / Editar {{$peridoExaman->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($peridoExaman, array('route' => array('peridoExamens.update', $peridoExaman->id),'method' => 'post')) !!}

@include('peridoExamens._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('peridoExamens.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection