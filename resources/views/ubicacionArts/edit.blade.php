@extends('plantillas.admin_template')

@include('ubicacionArts._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('ubicacionArts.index') }}">@yield('ubicacionArtsAppTitle')</a></li>
	    <li><a href="{{ route('ubicacionArts.show', $ubicacionArt->id) }}">{{ $ubicacionArt->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('ubicacionArtsAppTitle') / Editar {{$ubicacionArt->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($ubicacionArt, array('route' => array('ubicacionArts.update', $ubicacionArt->id),'method' => 'post')) !!}

@include('ubicacionArts._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('ubicacionArts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection