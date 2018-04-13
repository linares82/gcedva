@extends('plantillas.admin_template')

@include('planPagoLns._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('planPagoLns.index') }}">@yield('planPagoLnsAppTitle')</a></li>
	    <li><a href="{{ route('planPagoLns.show', $planPagoLn->id) }}">{{ $planPagoLn->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('planPagoLnsAppTitle') / Editar {{$planPagoLn->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($planPagoLn, array('route' => array('planPagoLns.update', $planPagoLn->id),'method' => 'post')) !!}

@include('planPagoLns._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('planPagoLns.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection