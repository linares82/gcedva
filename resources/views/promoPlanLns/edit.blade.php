@extends('plantillas.admin_template')

@include('promoPlanLns._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('promoPlanLns.index') }}">@yield('promoPlanLnsAppTitle')</a></li>
	    <li><a href="{{ route('promoPlanLns.show', $promoPlanLn->id) }}">{{ $promoPlanLn->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('promoPlanLnsAppTitle') / Editar {{$promoPlanLn->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($promoPlanLn, array('route' => array('promoPlanLns.update', $promoPlanLn->id),'method' => 'post')) !!}

@include('promoPlanLns._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('promoPlanLns.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection