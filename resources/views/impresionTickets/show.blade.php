@extends('plantillas.admin_template')

@include('impresionTickets._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('impresionTickets.index') }}">@yield('impresionTicketsAppTitle')</a></li>
    <li class="active">{{ $impresionTicket->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('impresionTicketsAppTitle') / Mostrar {{$impresionTicket->id}}

            {!! Form::model($impresionTicket, array('route' => array('impresionTickets.destroy', $impresionTicket->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('impresionTicket.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('impresionTickets.edit', $impresionTicket->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('impresionTicket.destroy')
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
                    <p class="form-control-static">{{$impresionTicket->id}}</p>
                </div>
                <div class="form-group">
                     <label for="caja_id">CAJA_ID</label>
                     <p class="form-control-static">{{$impresionTicket->caja_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="pago_id">PAGO_ID</label>
                     <p class="form-control-static">{{$impresionTicket->pago_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="toke_unico">TOKE_UNICO</label>
                     <p class="form-control-static">{{$impresionTicket->toke_unico}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$impresionTicket->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$impresionTicket->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('impresionTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection