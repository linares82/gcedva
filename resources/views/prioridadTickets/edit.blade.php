@extends('plantillas.admin_template')

@include('prioridadTickets._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('prioridadTickets.index') }}">@yield('prioridadTicketsAppTitle')</a></li>
	    <li><a href="{{ route('prioridadTickets.show', $prioridadTicket->id) }}">{{ $prioridadTicket->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('prioridadTicketsAppTitle') / Editar {{$prioridadTicket->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($prioridadTicket, array('route' => array('prioridadTickets.update', $prioridadTicket->id),'method' => 'post')) !!}

@include('prioridadTickets._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('prioridadTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection