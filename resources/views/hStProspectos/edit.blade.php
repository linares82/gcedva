@extends('plantillas.admin_template')

@include('hStProspectos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('hStProspectos.index') }}">@yield('hStProspectosAppTitle')</a></li>
	    <li><a href="{{ route('hStProspectos.show', $hStProspecto->id) }}">{{ $hStProspecto->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('hStProspectosAppTitle') / Editar {{$hStProspecto->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($hStProspecto, array('route' => array('hStProspectos.update', $hStProspecto->id),'method' => 'post')) !!}

@include('hStProspectos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('hStProspectos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection