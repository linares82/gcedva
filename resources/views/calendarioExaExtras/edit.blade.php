@extends('plantillas.admin_template')

@include('calendarioExaExtras._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('calendarioExaExtras.index') }}">@yield('calendarioExaExtrasAppTitle')</a></li>
	    <li><a href="{{ route('calendarioExaExtras.show', $calendarioExaExtra->id) }}">{{ $calendarioExaExtra->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('calendarioExaExtrasAppTitle') / Editar {{$calendarioExaExtra->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($calendarioExaExtra, array('route' => array('calendarioExaExtras.update', $calendarioExaExtra->id),'method' => 'post')) !!}

@include('calendarioExaExtras._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('calendarioExaExtras.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection