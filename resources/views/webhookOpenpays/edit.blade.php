@extends('plantillas.admin_template')

@include('webhookOpenpays._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('webhookOpenpays.index') }}">@yield('webhookOpenpaysAppTitle')</a></li>
	    <li><a href="{{ route('webhookOpenpays.show', $webhookOpenpay->id) }}">{{ $webhookOpenpay->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('webhookOpenpaysAppTitle') / Editar {{$webhookOpenpay->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($webhookOpenpay, array('route' => array('webhookOpenpays.update', $webhookOpenpay->id),'method' => 'post')) !!}

@include('webhookOpenpays._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('webhookOpenpays.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection