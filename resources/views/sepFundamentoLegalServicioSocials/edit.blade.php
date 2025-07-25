@extends('plantillas.admin_template')

@include('sepFundamentoLegalServicioSocials._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('sepFundamentoLegalServicioSocials.index') }}">@yield('sepFundamentoLegalServicioSocialsAppTitle')</a></li>
	    <li><a href="{{ route('sepFundamentoLegalServicioSocials.show', $sepFundamentoLegalServicioSocial->id) }}">{{ $sepFundamentoLegalServicioSocial->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('sepFundamentoLegalServicioSocialsAppTitle') / Editar {{$sepFundamentoLegalServicioSocial->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($sepFundamentoLegalServicioSocial, array('route' => array('sepFundamentoLegalServicioSocials.update', $sepFundamentoLegalServicioSocial->id),'method' => 'post')) !!}

@include('sepFundamentoLegalServicioSocials._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('sepFundamentoLegalServicioSocials.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection