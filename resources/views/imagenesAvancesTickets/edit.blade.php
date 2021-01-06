@extends('plantillas.admin_template')

@include('imagenesAvancesTickets._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('imagenesAvancesTickets.index') }}">@yield('imagenesAvancesTicketsAppTitle')</a></li>
	    <li><a href="{{ route('imagenesAvancesTickets.show', $imagenesAvancesTicket->id) }}">{{ $imagenesAvancesTicket->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('imagenesAvancesTicketsAppTitle') / Editar {{$imagenesAvancesTicket->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($imagenesAvancesTicket, array('route' => array('imagenesAvancesTickets.update', $imagenesAvancesTicket->id),'method' => 'post')) !!}

@include('imagenesAvancesTickets._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('imagenesAvancesTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection