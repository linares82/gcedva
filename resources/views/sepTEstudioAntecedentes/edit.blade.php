@extends('plantillas.admin_template')

@include('sepTEstudioAntecedentes._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepTEstudioAntecedentes.index') }}">@yield('sepTEstudioAntecedentesAppTitle')</a></li>
	    <li><a href="{{ route('sepTEstudioAntecedentes.show', $sepTEstudioAntecedente->id) }}">{{ $sepTEstudioAntecedente->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepTEstudioAntecedentesAppTitle') / Editar {{$sepTEstudioAntecedente->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepTEstudioAntecedente, array('route' => array('sepTEstudioAntecedentes.update', $sepTEstudioAntecedente->id),'method' => 'post')) !!}

@include('sepTEstudioAntecedentes._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepTEstudioAntecedentes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection