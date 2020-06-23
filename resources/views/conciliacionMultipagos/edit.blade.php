@extends('plantillas.admin_template')

@include('conciliacionMultipagos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('conciliacionMultipagos.index') }}">@yield('conciliacionMultipagosAppTitle')</a></li>
	    <li><a href="{{ route('conciliacionMultipagos.show', $conciliacionMultipago->id) }}">{{ $conciliacionMultipago->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('conciliacionMultipagosAppTitle') / Editar {{$conciliacionMultipago->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($conciliacionMultipago, array('route' => array('conciliacionMultipagos.update', $conciliacionMultipago->id),'method' => 'post')) !!}

@include('conciliacionMultipagos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('conciliacionMultipagos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection