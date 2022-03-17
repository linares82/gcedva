@extends('plantillas.admin_template')

@include('regimenFiscals._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('regimenFiscals.index') }}">@yield('regimenFiscalsAppTitle')</a></li>
	    <li><a href="{{ route('regimenFiscals.show', $regimenFiscal->id) }}">{{ $regimenFiscal->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('regimenFiscalsAppTitle') / Editar {{$regimenFiscal->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($regimenFiscal, array('route' => array('regimenFiscals.update', $regimenFiscal->id),'method' => 'post')) !!}

@include('regimenFiscals._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('regimenFiscals.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection