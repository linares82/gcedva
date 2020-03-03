@extends('plantillas.admin_template')

@include('impresionListaAsistens._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('impresionListaAsistens.index') }}">@yield('impresionListaAsistensAppTitle')</a></li>
	    <li><a href="{{ route('impresionListaAsistens.show', $impresionListaAsisten->id) }}">{{ $impresionListaAsisten->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('impresionListaAsistensAppTitle') / Editar {{$impresionListaAsisten->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($impresionListaAsisten, array('route' => array('impresionListaAsistens.update', $impresionListaAsisten->id),'method' => 'post')) !!}

@include('impresionListaAsistens._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('impresionListaAsistens.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection