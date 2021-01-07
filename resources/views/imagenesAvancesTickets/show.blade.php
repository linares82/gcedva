@extends('plantillas.admin_template')

@include('imagenesAvancesTickets._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('imagenesAvancesTickets.index') }}">@yield('imagenesAvancesTicketsAppTitle')</a></li>
    <li class="active">{{ $imagenesAvancesTicket->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('imagenesAvancesTicketsAppTitle') / Mostrar {{$imagenesAvancesTicket->id}}

            {!! Form::model($imagenesAvancesTicket, array('route' => array('imagenesAvancesTickets.destroy', $imagenesAvancesTicket->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('imagenesAvancesTicket.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('imagenesAvancesTickets.edit', $imagenesAvancesTicket->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('imagenesAvancesTicket.destroy')
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
                    <p class="form-control-static">{{$imagenesAvancesTicket->id}}</p>
                </div>
                <div class="form-group">
                     <label for="avances_ticket_detalle">AVANCES_TICKET_DETALLE</label>
                     <p class="form-control-static">{{$imagenesAvancesTicket->avancesTicket->detalle}}</p>
                </div>
                    <div class="form-group">
                     <label for="nombre">NOMBRE</label>
                     <p class="form-control-static">{{$imagenesAvancesTicket->nombre}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$imagenesAvancesTicket->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$imagenesAvancesTicket->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('imagenesAvancesTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection