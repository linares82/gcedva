@extends('plantillas.admin_template')

@include('prioridadTickets._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('prioridadTickets.index') }}">@yield('prioridadTicketsAppTitle')</a></li>
    <li class="active">{{ $prioridadTicket->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('prioridadTicketsAppTitle') / Mostrar {{$prioridadTicket->id}}

            {!! Form::model($prioridadTicket, array('route' => array('prioridadTickets.destroy', $prioridadTicket->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('prioridadTicket.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('prioridadTickets.edit', $prioridadTicket->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('prioridadTicket.destroy')
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
                    <p class="form-control-static">{{$prioridadTicket->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">PRIORIDAD</label>
                     <p class="form-control-static">{{$prioridadTicket->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$prioridadTicket->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$prioridadTicket->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('prioridadTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection