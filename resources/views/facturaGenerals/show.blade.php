@extends('plantillas.admin_template')

@include('facturaGenerals._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('facturaGenerals.index') }}">@yield('facturaGeneralsAppTitle')</a></li>
    <li class="active">{{ $facturaGeneral->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('facturaGeneralsAppTitle') / Mostrar {{$facturaGeneral->id}}

            {!! Form::model($facturaGeneral, array('route' => array('facturaGenerals.destroy', $facturaGeneral->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('facturaGeneral.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('facturaGenerals.edit', $facturaGeneral->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('facturaGeneral.destroy')
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
                    <p class="form-control-static">{{$facturaGeneral->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plantel_razon">PLANTEL_RAZON</label>
                     <p class="form-control-static">{{$facturaGeneral->plantel->razon}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_inicio">FEC_INICIO</label>
                     <p class="form-control-static">{{$facturaGeneral->fec_inicio}}</p>
                </div>
                    <div class="form-group">
                     <label for="fec_fin">FEC_FIN</label>
                     <p class="form-control-static">{{$facturaGeneral->fec_fin}}</p>
                </div>
                    <div class="form-group">
                     <label for="uuid">UUID</label>
                     <p class="form-control-static">{{$facturaGeneral->uuid}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$facturaGeneral->usu_alta->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$facturaGeneral->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('facturaGenerals.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection