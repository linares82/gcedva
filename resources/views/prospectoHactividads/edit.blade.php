@extends('plantillas.admin_template')

@include('prospectoHactividads._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('prospectoHactividads.index') }}">@yield('prospectoHactividadsAppTitle')</a></li>
	    <li><a href="{{ route('prospectoHactividads.show', $prospectoHactividad->id) }}">{{ $prospectoHactividad->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('prospectoHactividadsAppTitle') / Editar {{$prospectoHactividad->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($prospectoHactividad, array('route' => array('prospectoHactividads.update', $prospectoHactividad->id),'method' => 'post')) !!}

@include('prospectoHactividads._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('prospectoHactividads.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection