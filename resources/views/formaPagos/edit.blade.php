@extends('plantillas.admin_template')

@include('formaPagos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('formaPagos.index') }}">@yield('formaPagosAppTitle')</a></li>
	    <li><a href="{{ route('formaPagos.show', $formaPago->id) }}">{{ $formaPago->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('formaPagosAppTitle') / Editar {{$formaPago->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($formaPago, array('route' => array('formaPagos.update', $formaPago->id),'method' => 'post')) !!}

@include('formaPagos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('formaPagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection