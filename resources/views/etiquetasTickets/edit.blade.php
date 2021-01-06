@extends('plantillas.admin_template')

@include('etiquetasTickets._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('etiquetasTickets.index') }}">@yield('etiquetasTicketsAppTitle')</a></li>
	    <li><a href="{{ route('etiquetasTickets.show', $etiquetasTicket->id) }}">{{ $etiquetasTicket->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('etiquetasTicketsAppTitle') / Editar {{$etiquetasTicket->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($etiquetasTicket, array('route' => array('etiquetasTickets.update', $etiquetasTicket->id),'method' => 'post')) !!}

@include('etiquetasTickets._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('etiquetasTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection