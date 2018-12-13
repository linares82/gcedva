@extends('plantillas.admin_template')

@include('ebanxes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('ebanxes.index') }}">@yield('ebanxesAppTitle')</a></li>
	    <li><a href="{{ route('ebanxes.show', $ebanx->id) }}">{{ $ebanx->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('ebanxesAppTitle') / Editar {{$ebanx->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($ebanx, array('route' => array('ebanxes.update', $ebanx->id),'method' => 'post')) !!}

@include('ebanxes._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('ebanxes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection