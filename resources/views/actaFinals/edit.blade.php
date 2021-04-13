@extends('plantillas.admin_template')

@include('actaFinals._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('actaFinals.index') }}">@yield('actaFinalsAppTitle')</a></li>
	    <li><a href="{{ route('actaFinals.show', $actaFinal->id) }}">{{ $actaFinal->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('actaFinalsAppTitle') / Editar {{$actaFinal->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($actaFinal, array('route' => array('actaFinals.update', $actaFinal->id),'method' => 'post')) !!}

@include('actaFinals._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('actaFinals.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection