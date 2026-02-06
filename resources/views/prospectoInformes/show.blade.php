@extends('plantillas.admin_template')

@include('prospectoInformes._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('prospectoInformes.index') }}">@yield('prospectoInformesAppTitle')</a></li>
    <li class="active">{{ $prospectoInforme->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('prospectoInformesAppTitle') / Mostrar {{$prospectoInforme->id}}

            {!! Form::model($prospectoInforme, array('route' => array('prospectoInformes.destroy', $prospectoInforme->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('prospectoInforme.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('prospectoInformes.edit', $prospectoInforme->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('prospectoInforme.destroy')
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
                    <p class="form-control-static">{{$prospectoInforme->id}}</p>
                </div>
                <div class="form-group">
                     <label for="prospecto_parte_informe_id">PROSPECTO_PARTE_INFORME_ID</label>
                     <p class="form-control-static">{{$prospectoInforme->prospecto_parte_informe_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="prospecto_etiqueta_id">PROSPECTO_ETIQUETA_ID</label>
                     <p class="form-control-static">{{$prospectoInforme->prospecto_etiqueta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="detalle">DETALLE</label>
                     <p class="form-control-static">{{$prospectoInforme->detalle}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$prospectoInforme->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$prospectoInforme->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('prospectoInformes.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection