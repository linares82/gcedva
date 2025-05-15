@extends('plantillas.admin_template')

@include('sepCertificadoCs._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepCertificadoCs.index') }}">@yield('sepCertificadoCsAppTitle')</a></li>
	    <li><a href="{{ route('sepCertificadoCs.show', $sepCertificadoC->id) }}">{{ $sepCertificadoC->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepCertificadoCsAppTitle') / Editar {{$sepCertificadoC->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepCertificadoC, array('route' => array('sepCertificadoCs.update', $sepCertificadoC->id),'method' => 'post')) !!}

@include('sepCertificadoCs._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepCertificadoCs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection