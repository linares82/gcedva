@extends('plantillas.admin_template')

@include('prospectoEtiquetas._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('prospectoEtiquetas.index') }}">@yield('prospectoEtiquetasAppTitle')</a></li>
	    <li><a href="{{ route('prospectoEtiquetas.show', $prospectoEtiquetum->id) }}">{{ $prospectoEtiquetum->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('prospectoEtiquetasAppTitle') / Editar {{$prospectoEtiquetum->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($prospectoEtiquetum, array('route' => array('prospectoEtiquetas.update', $prospectoEtiquetum->id),'method' => 'post')) !!}

@include('prospectoEtiquetas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('prospectoEtiquetas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection