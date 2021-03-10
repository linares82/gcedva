@extends('plantillas.admin_template')

@include('hStProspectos._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('hStProspectos.index') }}">@yield('hStProspectosAppTitle')</a></li>
	    <li class="active">Crear</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-plus"></i> @yield('hStProspectosAppTitle') / Crear </h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::open(array('route' => 'hStProspectos.store')) !!}

@include('hStProspectos._form')

                <div class="row">
                </div>
                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Crear</button>
                    <a class="btn btn-link pull-right" href="{{ route('hStProspectos.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection