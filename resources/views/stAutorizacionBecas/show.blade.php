@extends('plantillas.admin_template')

@include('stAutorizacionBecas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('stAutorizacionBecas.index') }}">@yield('stAutorizacionBecasAppTitle')</a></li>
    <li class="active">{{ $stAutorizacionBeca->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('stAutorizacionBecasAppTitle') / Mostrar {{$stAutorizacionBeca->id}}

            {!! Form::model($stAutorizacionBeca, array('route' => array('stAutorizacionBecas.destroy', $stAutorizacionBeca->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('stAutorizacionBeca.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('stAutorizacionBecas.edit', $stAutorizacionBeca->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('stAutorizacionBeca.destroy')
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
                    <p class="form-control-static">{{$stAutorizacionBeca->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">ESTATUS</label>
                     <p class="form-control-static">{{$stAutorizacionBeca->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$stAutorizacionBeca->usu_alta->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$stAutorizacionBeca->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('stAutorizacionBecas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection