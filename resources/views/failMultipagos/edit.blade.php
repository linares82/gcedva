@extends('plantillas.admin_template')

@include('failMultipagos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('failMultipagos.index') }}">@yield('failMultipagosAppTitle')</a></li>
	    <li><a href="{{ route('failMultipagos.show', $failMultipago->id) }}">{{ $failMultipago->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('failMultipagosAppTitle') / Editar {{$failMultipago->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($failMultipago, array('route' => array('failMultipagos.update', $failMultipago->id),'method' => 'post')) !!}

@include('failMultipagos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('failMultipagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection