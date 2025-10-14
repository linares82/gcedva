@extends('plantillas.admin_template')

@include('setyceLotes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('setyceLotes.index') }}">@yield('setyceLotesAppTitle')</a></li>
	    <li><a href="{{ route('setyceLotes.show', $setyceLote->id) }}">{{ $setyceLote->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('setyceLotesAppTitle') / Editar {{$setyceLote->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($setyceLote, array('route' => array('setyceLotes.update', $setyceLote->id),'method' => 'post')) !!}

@include('setyceLotes._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('setyceLotes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection