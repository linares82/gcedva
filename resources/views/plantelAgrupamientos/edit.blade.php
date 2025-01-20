@extends('plantillas.admin_template')

@include('plantelAgrupamientos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('plantelAgrupamientos.index') }}">@yield('plantelAgrupamientosAppTitle')</a></li>
	    <li><a href="{{ route('plantelAgrupamientos.show', $plantelAgrupamiento->id) }}">{{ $plantelAgrupamiento->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('plantelAgrupamientosAppTitle') / Editar {{$plantelAgrupamiento->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($plantelAgrupamiento, array('route' => array('plantelAgrupamientos.update', $plantelAgrupamiento->id),'method' => 'post')) !!}

@include('plantelAgrupamientos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('plantelAgrupamientos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection