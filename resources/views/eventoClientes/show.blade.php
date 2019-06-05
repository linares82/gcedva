@extends('plantillas.admin_template')

@include('eventoClientes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('eventoClientes.index') }}">@yield('eventoClientesAppTitle')</a></li>
    <li class="active">{{ $eventoCliente->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('eventoClientesAppTitle') / Mostrar {{$eventoCliente->id}}

            {!! Form::model($eventoCliente, array('route' => array('eventoClientes.destroy', $eventoCliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('eventoCliente.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('eventoClientes.edit', $eventoCliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('eventoCliente.destroy')
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
                    <p class="form-control-static">{{$eventoCliente->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">EVENTO</label>
                     <p class="form-control-static">{{$eventoCliente->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$eventoCliente->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$eventoCliente->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('eventoClientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection