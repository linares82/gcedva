@extends('plantillas.admin_template')

@include('serieFolioSimplificados._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('serieFolioSimplificados.index') }}">@yield('serieFolioSimplificadosAppTitle')</a></li>
	    <li><a href="{{ route('serieFolioSimplificados.show', $serieFolioSimplificado->id) }}">{{ $serieFolioSimplificado->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('serieFolioSimplificadosAppTitle') / Editar {{$serieFolioSimplificado->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($serieFolioSimplificado, array('route' => array('serieFolioSimplificados.update', $serieFolioSimplificado->id),'method' => 'post')) !!}

@include('serieFolioSimplificados._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('serieFolioSimplificados.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection