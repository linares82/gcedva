@extends('plantillas.admin_template')

@include('historiaEventos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('historiaEventos.index') }}">@yield('historiaEventosAppTitle')</a></li>
    <li class="active">{{ $historiaEvento->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('historiaEventosAppTitle') / Mostrar {{$historiaEvento->id}}

            {!! Form::model($historiaEvento, array('route' => array('historiaEventos.destroy', $historiaEvento->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('historiaEvento.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('historiaEventos.edit', $historiaEvento->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('historiaEvento.destroy')
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
                    <p class="form-control-static">{{$historiaEvento->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">EVENTO</label>
                     <p class="form-control-static">{{$historiaEvento->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$historiaEvento->usu_alta_id}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">ULTIMA MODIFICACION</label>
                     <p class="form-control-static">{{$historiaEvento->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('historiaEventos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection