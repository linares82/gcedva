@extends('plantillas.admin_template')

@include('prospectoInformes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('prospectoInformes.index') }}">@yield('prospectoInformesAppTitle')</a></li>
	    <li><a href="{{ route('prospectoInformes.show', $prospectoInforme->id) }}">{{ $prospectoInforme->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('prospectoInformesAppTitle') / Editar {{$prospectoInforme->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($prospectoInforme, array('route' => array('prospectoInformes.update', $prospectoInforme->id),'method' => 'post')) !!}

@include('prospectoInformes._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('prospectoInformes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection