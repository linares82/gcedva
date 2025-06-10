@extends('plantillas.admin_template')

@include('sepModalidadTitulacions._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepModalidadTitulacions.index') }}">@yield('sepModalidadTitulacionsAppTitle')</a></li>
	    <li><a href="{{ route('sepModalidadTitulacions.show', $sepModalidadTitulacion->id) }}">{{ $sepModalidadTitulacion->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepModalidadTitulacionsAppTitle') / Editar {{$sepModalidadTitulacion->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepModalidadTitulacion, array('route' => array('sepModalidadTitulacions.update', $sepModalidadTitulacion->id),'method' => 'post')) !!}

@include('sepModalidadTitulacions._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepModalidadTitulacions.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection