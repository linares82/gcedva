@extends('plantillas.admin_template')

@include('titulacionPagos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('titulacionPagos.index') }}">@yield('titulacionPagosAppTitle')</a></li>
	    <li><a href="{{ route('titulacionPagos.show', $titulacionPago->id) }}">{{ $titulacionPago->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('titulacionPagosAppTitle') / Editar {{$titulacionPago->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($titulacionPago, array('route' => array('titulacionPagos.update', $titulacionPago->id),'method' => 'post')) !!}

@include('titulacionPagos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('titulacionPagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection