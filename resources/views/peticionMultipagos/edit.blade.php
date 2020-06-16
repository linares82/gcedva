@extends('plantillas.admin_template')

@include('peticionMultipagos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('peticionMultipagos.index') }}">@yield('peticionMultipagosAppTitle')</a></li>
	    <li><a href="{{ route('peticionMultipagos.show', $peticionMultipago->id) }}">{{ $peticionMultipago->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('peticionMultipagosAppTitle') / Editar {{$peticionMultipago->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($peticionMultipago, array('route' => array('peticionMultipagos.update', $peticionMultipago->id),'method' => 'post')) !!}

@include('peticionMultipagos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('peticionMultipagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection