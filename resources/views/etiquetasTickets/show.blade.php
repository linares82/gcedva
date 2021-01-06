@extends('plantillas.admin_template')

@include('etiquetasTickets._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('etiquetasTickets.index') }}">@yield('etiquetasTicketsAppTitle')</a></li>
    <li class="active">{{ $etiquetasTicket->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('etiquetasTicketsAppTitle') / Mostrar {{$etiquetasTicket->id}}

            {!! Form::model($etiquetasTicket, array('route' => array('etiquetasTickets.destroy', $etiquetasTicket->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('etiquetasTicket.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('etiquetasTickets.edit', $etiquetasTicket->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('etiquetasTicket.destroy')
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
                    <p class="form-control-static">{{$etiquetasTicket->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">ETIQUETA</label>
                     <p class="form-control-static">{{$etiquetasTicket->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$etiquetasTicket->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$etiquetasTicket->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('etiquetasTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection