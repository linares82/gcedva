@extends('plantillas.admin_template')

@include('tpoInformes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('tpoInformes.index') }}">@yield('tpoInformesAppTitle')</a></li>
	    <li><a href="{{ route('tpoInformes.show', $tpoInforme->id) }}">{{ $tpoInforme->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('tpoInformesAppTitle') / Editar {{$tpoInforme->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($tpoInforme, array('route' => array('tpoInformes.update', $tpoInforme->id),'method' => 'post')) !!}

@include('tpoInformes._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('tpoInformes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection