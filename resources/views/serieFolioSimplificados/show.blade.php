@extends('plantillas.admin_template')

@include('serieFolioSimplificados._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('serieFolioSimplificados.index') }}">@yield('serieFolioSimplificadosAppTitle')</a></li>
    <li class="active">{{ $serieFolioSimplificado->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('serieFolioSimplificadosAppTitle') / Mostrar {{$serieFolioSimplificado->id}}

            {!! Form::model($serieFolioSimplificado, array('route' => array('serieFolioSimplificados.destroy', $serieFolioSimplificado->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('serieFolioSimplificado.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('serieFolioSimplificados.edit', $serieFolioSimplificado->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('serieFolioSimplificado.destroy')
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
                    <p class="form-control-static">{{$serieFolioSimplificado->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cuenta_p_name">CUENTA_P_NAME</label>
                     <p class="form-control-static">{{$serieFolioSimplificado->cuentaP->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="serie">SERIE</label>
                     <p class="form-control-static">{{$serieFolioSimplificado->serie}}</p>
                </div>
                    <div class="form-group">
                     <label for="folio_inicial">FOLIO_INICIAL</label>
                     <p class="form-control-static">{{$serieFolioSimplificado->folio_inicial}}</p>
                </div>
                    <div class="form-group">
                     <label for="folio_actual">FOLIO_ACTUAL</label>
                     <p class="form-control-static">{{$serieFolioSimplificado->folio_actual}}</p>
                </div>
                    <div class="form-group">
                     <label for="anio">ANIO</label>
                     <p class="form-control-static">{{$serieFolioSimplificado->anio}}</p>
                </div>
                    <div class="form-group">
                     <label for="mes_id">MES_ID</label>
                     <p class="form-control-static">{{$serieFolioSimplificado->mes_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_activo">BND_ACTIVO</label>
                     <p class="form-control-static">{{$serieFolioSimplificado->bnd_activo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$serieFolioSimplificado->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$serieFolioSimplificado->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('serieFolioSimplificados.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection