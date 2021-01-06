@extends('plantillas.admin_template')

@include('categoriaTickets._common')

@section('header')

	<ol class="breadcrumb">
	    <li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
	    <li><a href="{{ route('categoriaTickets.index') }}">@yield('categoriaTicketsAppTitle')</a></li>
	    <li><a href="{{ route('categoriaTickets.show', $categoriaTicket->id) }}">{{ $categoriaTicket->id }}</a></li>
	    <li class="active">Editar</li>
	</ol>

    <div class="page-header">
        <h3><i class="glyphicon glyphicon-edit"></i> @yield('categoriaTicketsAppTitle') / Editar {{$categoriaTicket->id}}</h3>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-md-12">

            {!! Form::model($categoriaTicket, array('route' => array('categoriaTickets.update', $categoriaTicket->id),'method' => 'post')) !!}

@include('categoriaTickets._form')

                <div class="row">
                </div>

                <div class="well well-sm">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <a class="btn btn-link pull-right" href="{{ route('categoriaTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>
                </div>
            {!! Form::close() !!}

        </div>
    </div>
@endsection