@extends('plantillas.admin_template')

@include('categoriaTickets._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('categoriaTickets.index') }}">@yield('categoriaTicketsAppTitle')</a></li>
    <li class="active">{{ $categoriaTicket->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('categoriaTicketsAppTitle') / Mostrar {{$categoriaTicket->id}}

            {!! Form::model($categoriaTicket, array('route' => array('categoriaTickets.destroy', $categoriaTicket->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('categoriaTicket.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('categoriaTickets.edit', $categoriaTicket->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('categoriaTicket.destroy')
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
                    <p class="form-control-static">{{$categoriaTicket->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">CATEGORIA</label>
                     <p class="form-control-static">{{$categoriaTicket->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$categoriaTicket->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$categoriaTicket->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('categoriaTickets.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection