@extends('plantillas.admin_template')

@include('plantelInventarios._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('plantelInventarios.index') }}">@yield('plantelInventariosAppTitle')</a></li>
	    <li><a href="{{ route('plantelInventarios.show', $plantelInventario->id) }}">{{ $plantelInventario->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('plantelInventariosAppTitle') / Editar {{$plantelInventario->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($plantelInventario, array('route' => array('plantelInventarios.update', $plantelInventario->id),'method' => 'post')) !!}

@include('plantelInventarios._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('plantelInventarios.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection