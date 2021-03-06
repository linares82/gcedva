@extends('plantillas.admin_template')

@include('avancesTickets._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('avancesTickets.index') }}">@yield('avancesTicketsAppTitle')</a></li>
	    <li><a href="{{ route('avancesTickets.show', $avancesTicket->id) }}">{{ $avancesTicket->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('avancesTicketsAppTitle') / Editar {{$avancesTicket->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($avancesTicket, array('route' => array('avancesTickets.update', $avancesTicket->id),'method' => 'post')) !!}

@include('avancesTickets._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('tickets.show',$avancesTicket->ticket_id) }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection