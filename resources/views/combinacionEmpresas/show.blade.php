@extends('plantillas.admin_template')

@include('combinacionEmpresas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('combinacionEmpresas.index') }}">@yield('combinacionEmpresasAppTitle')</a></li>
    <li class="active">{{ $combinacionEmpresa->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('combinacionEmpresasAppTitle') / Mostrar {{$combinacionEmpresa->id}}

            {!! Form::model($combinacionEmpresa, array('route' => array('combinacionEmpresas.destroy', $combinacionEmpresa->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('combinacionEmpresa.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('combinacionEmpresas.edit', $combinacionEmpresa->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('combinacionEmpresa.destroy')
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
                    <p class="form-control-static">{{$combinacionEmpresa->id}}</p>
                </div>
                <div class="form-group">
                     <label for="empresa_id">EMPRESA_ID</label>
                     <p class="form-control-static">{{$combinacionEmpresa->empresa_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="plantel_id">PLANTEL_ID</label>
                     <p class="form-control-static">{{$combinacionEmpresa->plantel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="especialidad_id">ESPECIALIDAD_ID</label>
                     <p class="form-control-static">{{$combinacionEmpresa->especialidad_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="nivel_id">NIVEL_ID</label>
                     <p class="form-control-static">{{$combinacionEmpresa->nivel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="grado_id">GRADO_ID</label>
                     <p class="form-control-static">{{$combinacionEmpresa->grado_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$combinacionEmpresa->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$combinacionEmpresa->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('combinacionEmpresas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection