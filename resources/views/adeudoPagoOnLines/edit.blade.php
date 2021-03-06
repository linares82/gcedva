@extends('plantillas.admin_template')

@include('adeudoPagoOnLines._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('adeudoPagoOnLines.index') }}">@yield('adeudoPagoOnLinesAppTitle')</a></li>
	    <li><a href="{{ route('adeudoPagoOnLines.show', $adeudoPagoOnLine->id) }}">{{ $adeudoPagoOnLine->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('adeudoPagoOnLinesAppTitle') / Editar {{$adeudoPagoOnLine->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($adeudoPagoOnLine, array('route' => array('adeudoPagoOnLines.update', $adeudoPagoOnLine->id),'method' => 'post')) !!}

@include('adeudoPagoOnLines._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('adeudoPagoOnLines.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection