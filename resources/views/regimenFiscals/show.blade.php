@extends('plantillas.admin_template')

@include('regimenFiscals._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('regimenFiscals.index') }}">@yield('regimenFiscalsAppTitle')</a></li>
    <li class="active">{{ $regimenFiscal->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('regimenFiscalsAppTitle') / Mostrar {{$regimenFiscal->id}}

            {!! Form::model($regimenFiscal, array('route' => array('regimenFiscals.destroy', $regimenFiscal->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('regimenFiscal.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('regimenFiscals.edit', $regimenFiscal->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('regimenFiscal.destroy')
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
                    <p class="form-control-static">{{$regimenFiscal->id}}</p>
                </div>
                <div class="form-group">
                     <label for="clave">CLAVE</label>
                     <p class="form-control-static">{{$regimenFiscal->clave}}</p>
                </div>
                    <div class="form-group">
                     <label for="descripcion">DESCRIPCION</label>
                     <p class="form-control-static">{{$regimenFiscal->descripcion}}</p>
                </div>
                    <div class="form-group">
                     <label for="activo">ACTIVO</label>
                     <p class="form-control-static">{{$regimenFiscal->activo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$regimenFiscal->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$regimenFiscal->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('regimenFiscals.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection