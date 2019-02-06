@extends('plantillas.admin_template')

@include('avisosEmpresas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('avisosEmpresas.index') }}">@yield('avisosEmpresasAppTitle')</a></li>
    <li class="active">{{ $avisosEmpresa->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('avisosEmpresasAppTitle') / Mostrar {{$avisosEmpresa->id}}

            {!! Form::model($avisosEmpresa, array('route' => array('avisosEmpresas.destroy', $avisosEmpresa->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('avisosEmpresa.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('avisosEmpresas.edit', $avisosEmpresa->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('avisosEmpresa.destroy')
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
                    <p class="form-control-static">{{$avisosEmpresa->id}}</p>
                </div>
                <div class="form-group">
                     <label for="empresa_razon_social">EMPRESA_RAZON_SOCIAL</label>
                     <p class="form-control-static">{{$avisosEmpresa->empresa->razon_social}}</p>
                </div>
                    <div class="form-group">
                     <label for="asunto_name">ASUNTO_NAME</label>
                     <p class="form-control-static">{{$avisosEmpresa->asunto->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$avisosEmpresa->detalle}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha">FECHA</label>
                     <p class="form-control-static">{{$avisosEmpresa->fecha}}</p>
                </div>
                    <div class="form-group">
                     <label for="activo">ACTIVO</label>
                     <p class="form-control-static">{{$avisosEmpresa->activo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$avisosEmpresa->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$avisosEmpresa->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('avisosEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection