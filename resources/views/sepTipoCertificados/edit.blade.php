@extends('plantillas.admin_template')

@include('sepTipoCertificados._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepTipoCertificados.index') }}">@yield('sepTipoCertificadosAppTitle')</a></li>
	    <li><a href="{{ route('sepTipoCertificados.show', $sepTipoCertificado->id) }}">{{ $sepTipoCertificado->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepTipoCertificadosAppTitle') / Editar {{$sepTipoCertificado->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepTipoCertificado, array('route' => array('sepTipoCertificados.update', $sepTipoCertificado->id),'method' => 'post')) !!}

@include('sepTipoCertificados._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepTipoCertificados.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection