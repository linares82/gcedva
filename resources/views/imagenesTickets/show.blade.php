@extends('plantillas.admin_template')

@include('imagenesTickets._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('imagenesTickets.index') }}">@yield('imagenesTicketsAppTitle')</a></li>
    <li class="active">{{ $imagenesTicket->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('imagenesTicketsAppTitle') / Mostrar {{$imagenesTicket->id}}

            {!! Form::model($imagenesTicket, array('route' => array('imagenesTickets.destroy', $imagenesTicket->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('imagenesTicket.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('imagenesTickets.edit', $imagenesTicket->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('imagenesTicket.destroy')
                    <button type="submit" class="btn btn-danger">Borrar <i class="glyphicon glyphicon-trash"></i><
                    /button>
                    @endpermission
                </div>
            {!! Form::close() !!}

        </h1>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">

            <form action="#">
                <div class="form-group col-sm-4">
                    <label for="nome">ID</label>
                    <p class="form-control-static">{{$imagenesTicket->id}}</p>
                </div>
                <div class="form-group">
                     <label for="ticket_nombre_corto">TICKET_NOMBRE_CORTO</label>
                     <p class="form-control-static">{{$imagenesTicket->ticket->nombre_corto}}</p>
                </div>
                    <div class="form-group">
                     <label for="nombre">NOMBRE</label>
                     <p class="form-control-static">{{$imagenesTicket->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$imagenesTicket->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$imagenesTicket->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('imagenesTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection