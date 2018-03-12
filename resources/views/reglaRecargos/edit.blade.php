@extends('plantillas.admin_template')

@include('reglaRecargos._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('reglaRecargos.index') }}">@yield('reglaRecargosAppTitle')</a></li>
	    <li><a href="{{ route('reglaRecargos.show', $reglaRecargo->id) }}">{{ $reglaRecargo->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('reglaRecargosAppTitle') / Editar {{$reglaRecargo->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($reglaRecargo, array('route' => array('reglaRecargos.update', $reglaRecargo->id),'method' => 'post')) !!}

@include('reglaRecargos._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('reglaRecargos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection