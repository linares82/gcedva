@extends('plantillas.admin_template')

@include('successMultipagos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('successMultipagos.index') }}">@yield('successMultipagosAppTitle')</a></li>
	    <li><a href="{{ route('successMultipagos.show', $successMultipago->id) }}">{{ $successMultipago->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('successMultipagosAppTitle') / Editar {{$successMultipago->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($successMultipago, array('route' => array('successMultipagos.update', $successMultipago->id),'method' => 'post')) !!}

@include('successMultipagos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('successMultipagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection