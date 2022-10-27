@extends('plantillas.admin_template')

@include('prospectoHistoricoSts._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('prospectoHistoricoSts.index') }}">@yield('prospectoHistoricoStsAppTitle')</a></li>
	    <li><a href="{{ route('prospectoHistoricoSts.show', $prospectoHistoricoSt->id) }}">{{ $prospectoHistoricoSt->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('prospectoHistoricoStsAppTitle') / Editar {{$prospectoHistoricoSt->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($prospectoHistoricoSt, array('route' => array('prospectoHistoricoSts.update', $prospectoHistoricoSt->id),'method' => 'post')) !!}

@include('prospectoHistoricoSts._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('prospectoHistoricoSts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection