@extends('plantillas.admin_template')

@include('autorizacionBecaComentarios._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('autorizacionBecaComentarios.index') }}">@yield('autorizacionBecaComentariosAppTitle')</a></li>
	    <li class="active">Duplicate</li>
	</ol>

    <div class="page-header">
        <h1><i class="glyphicon glyphicon-duplicate"></i> @yield('autorizacionBecaComentariosAppTitle') / Duplicar {{$autorizacionBecaComentario->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($autorizacionBecaComentario, array('route' => array('autorizacionBecaComentarios.store'))) !!}

@include('autorizacionBecaComentarios._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Duplicar</button>
                    <a class="btn btn-link pull-right" href="{{ route('autorizacionBecaComentarios.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection