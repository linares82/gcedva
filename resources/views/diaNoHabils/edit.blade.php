@extends('plantillas.admin_template')

@include('diaNoHabils._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('diaNoHabils.index') }}">@yield('diaNoHabilsAppTitle')</a></li>
	    <li><a href="{{ route('diaNoHabils.show', $diaNoHabil->id) }}">{{ $diaNoHabil->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('diaNoHabilsAppTitle') / Editar {{$diaNoHabil->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($diaNoHabil, array('route' => array('diaNoHabils.update', $diaNoHabil->id),'method' => 'post')) !!}

@include('diaNoHabils._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('diaNoHabils.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection