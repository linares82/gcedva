@extends('plantillas.admin_template')

@include('plantillaEmpresas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('plantillaEmpresas.index') }}">@yield('plantillaEmpresasAppTitle')</a></li>
    <li class="active">{{ $plantillaEmpresa->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('plantillaEmpresasAppTitle') / Mostrar {{$plantillaEmpresa->id}}

            {!! Form::model($plantillaEmpresa, array('route' => array('plantillaEmpresas.destroy', $plantillaEmpresa->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('plantillaEmpresa.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('plantillaEmpresas.edit', $plantillaEmpresa->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('plantillaEmpresa.destroy')
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
                    <p class="form-control-static">{{$plantillaEmpresa->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="plantilla">PLANTILLA</label>
                     <p class="form-control-static">{{$plantillaEmpresa->plantilla}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="nombre">NOMBRE</label>
                     <p class="form-control-static">{{$plantillaEmpresa->nombre}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$plantillaEmpresa->detalle}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="asunto">ASUNTO</label>
                     <p class="form-control-static">{{$plantillaEmpresa->asunto}}</p>
                </div>
                    
                    <div class="form-group col-sm-4">
                     <label for="dia">DIA</label>
                     <p class="form-control-static">{{$plantillaEmpresa->dia}}</p>
                </div>
                    
                    <div class="form-group col-sm-4">
                     <label for="activo_bnd">ACTIVO_BND</label>
                     <p class="form-control-static">{{$plantillaEmpresa->activo_bnd}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="sms_bnd">SMS_BND</label>
                     <p class="form-control-static">{{$plantillaEmpresa->sms_bnd}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="mail_bnd">MAIL_BND</label>
                     <p class="form-control-static">{{$plantillaEmpresa->mail_bnd}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="sms">SMS</label>
                     <p class="form-control-static">{{$plantillaEmpresa->sms}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="inicio">INICIO</label>
                     <p class="form-control-static">{{$plantillaEmpresa->inicio}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="fin">FIN</label>
                     <p class="form-control-static">{{$plantillaEmpresa->fin}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$plantillaEmpresa->usu_alta_id}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$plantillaEmpresa->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('plantillaEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection