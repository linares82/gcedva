@extends('plantillas.admin_template')

@include('tipoPrecioCotis._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('tipoPrecioCotis.index') }}">@yield('tipoPrecioCotisAppTitle')</a></li>
	    <li><a href="{{ route('tipoPrecioCotis.show', $tipoPrecioCoti->id) }}">{{ $tipoPrecioCoti->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('tipoPrecioCotisAppTitle') / Editar {{$tipoPrecioCoti->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($tipoPrecioCoti, array('route' => array('tipoPrecioCotis.update', $tipoPrecioCoti->id),'method' => 'post')) !!}

@include('tipoPrecioCotis._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('tipoPrecioCotis.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection