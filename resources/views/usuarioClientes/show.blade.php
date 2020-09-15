@extends('plantillas.admin_template')

@include('usarioClientes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('usarioClientes.index') }}">@yield('usarioClientesAppTitle')</a></li>
    <li class="active">{{ $usarioCliente->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('usarioClientesAppTitle') / Mostrar {{$usarioCliente->id}}

            {!! Form::model($usarioCliente, array('route' => array('usarioClientes.destroy', $usarioCliente->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('usarioCliente.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('usarioClientes.edit', $usarioCliente->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('usarioCliente.destroy')
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
                    <p class="form-control-static">{{$usarioCliente->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$usarioCliente->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="email">EMAIL</label>
                     <p class="form-control-static">{{$usarioCliente->email}}</p>
                </div>
                    <div class="form-group">
                     <label for="password">PASSWORD</label>
                     <p class="form-control-static">{{$usarioCliente->password}}</p>
                </div>
                    <div class="form-group">
                     <label for="nivel">NIVEL</label>
                     <p class="form-control-static">{{$usarioCliente->nivel}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$usarioCliente->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$usarioCliente->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('usarioClientes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection