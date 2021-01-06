@extends('plantillas.admin_template')

@include('avancesTickets._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('avancesTickets.index') }}">@yield('avancesTicketsAppTitle')</a></li>
    <li class="active">{{ $avancesTicket->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('avancesTicketsAppTitle') / Mostrar {{$avancesTicket->id}}

            {!! Form::model($avancesTicket, array('route' => array('avancesTickets.destroy', $avancesTicket->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('avancesTicket.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('avancesTickets.edit', $avancesTicket->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('avancesTicket.destroy')
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
                    <p class="form-control-static">{{$avancesTicket->id}}</p>
                </div>
                <div class="form-group">
                     <label for="ticket_nombre_corto">TICKET_NOMBRE_CORTO</label>
                     <p class="form-control-static">{{$avancesTicket->ticket->nombre_corto}}</p>
                </div>
                    <div class="form-group">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$avancesTicket->detalle}}</p>
                </div>
                    <div class="form-group">
                     <label for="asignado_a">ASIGNADO_A</label>
                     <p class="form-control-static">{{$avancesTicket->asignado_a}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_ticket_name">ST_TICKET_NAME</label>
                     <p class="form-control-static">{{$avancesTicket->stTicket->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$avancesTicket->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$avancesTicket->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('avancesTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection