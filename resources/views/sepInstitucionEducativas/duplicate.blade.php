@extends('plantillas.admin_template')

@include('sepInstitucionEducativas._common')

@section('header')

	<ol class="breadcrumb">
		<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepInstitucionEducativas.index') }}">@yield('sepInstitucionEducativasAppTitle')</a></li>
	    <li class="active">Duplicate</li>
	</ol>

    <div class="page-header">
        <h1><i class="glyphicon glyphicon-duplicate"></i> @yield('sepInstitucionEducativasAppTitle') / Duplicar {{$sepInstitucionEducativa->id}}</h1>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepInstitucionEducativa, array('route' => array('sepInstitucionEducativas.store'))) !!}

@include('sepInstitucionEducativas._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Duplicar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepInstitucionEducativas.index') }}"><i class="glyphicon glyphicon-backward"></i> Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection