@extends('plantillas.admin_template')

@include('inventarioLevantamientoSts._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('inventarioLevantamientoSts.index') }}">@yield('inventarioLevantamientoStsAppTitle')</a></li>
	    <li class="active">Duplicate</li>
	</ol>

    <div class="page-header">
        <h1><i class="glyphicon glyphicon-duplicate"></i> @yield('inventarioLevantamientoStsAppTitle') / Duplicar {{$inventarioLevantamientoSt->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($inventarioLevantamientoSt, array('route' => array('inventarioLevantamientoSts.store'))) !!}

@include('inventarioLevantamientoSts._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Duplicar</button>
                    <a class="btn btn-link pull-right" href="{{ route('inventarioLevantamientoSts.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection