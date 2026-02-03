@extends('plantillas.admin_template')

@include('leadHEstatuses._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('leadHEstatuses.index') }}">@yield('leadHEstatusesAppTitle')</a></li>
    <li class="active">{{ $leadHEstatus->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('leadHEstatusesAppTitle') / Mostrar {{$leadHEstatus->id}}

            {!! Form::model($leadHEstatus, array('route' => array('leadHEstatuses.destroy', $leadHEstatus->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('leadHEstatus.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('leadHEstatuses.edit', $leadHEstatus->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('leadHEstatus.destroy')
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
                    <p class="form-control-static">{{$leadHEstatus->id}}</p>
                </div>
                <div class="form-group">
                     <label for="lead_id">LEAD_ID</label>
                     <p class="form-control-static">{{$leadHEstatus->lead_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="st_lead_id">ST_LEAD_ID</label>
                     <p class="form-control-static">{{$leadHEstatus->st_lead_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$leadHEstatus->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$leadHEstatus->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$leadHEstatus->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('leadHEstatuses.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection