@extends('plantillas.admin_template')

@include('escolaridads._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('escolaridads.index') }}">@yield('escolaridadsAppTitle')</a></li>
	    <li class="active">Duplicate</li>
	</ol>

    <div class="page-header">
        <h1><i class="glyphicon glyphicon-duplicate"></i> @yield('escolaridadsAppTitle') / Duplicar {{$escolaridad->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($escolaridad, array('route' => array('escolaridads.store'))) !!}

@include('escolaridads._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Duplicar</button>
                    <a class="btn btn-link pull-right" href="{{ route('escolaridads.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection