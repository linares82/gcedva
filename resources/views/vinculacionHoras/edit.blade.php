@extends('plantillas.admin_template')

@include('vinculacionHoras._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('vinculacionHoras.index') }}">@yield('vinculacionHorasAppTitle')</a></li>
	    <li><a href="{{ route('vinculacionHoras.show', $vinculacionHora->id) }}">{{ $vinculacionHora->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('vinculacionHorasAppTitle') / Editar {{$vinculacionHora->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($vinculacionHora, array('route' => array('vinculacionHoras.update', $vinculacionHora->id),'method' => 'post')) !!}

@include('vinculacionHoras._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('vinculacionHoras.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection