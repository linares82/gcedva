@extends('plantillas.admin_template')

@include('sepTituloLs._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('sepTituloLs.index') }}">@yield('sepTituloLsAppTitle')</a></li>
    <li class="active">{{ $sepTituloL->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('sepTituloLsAppTitle') / Mostrar {{$sepTituloL->id}}

            {!! Form::model($sepTituloL, array('route' => array('sepTituloLs.destroy', $sepTituloL->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('sepTituloL.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('sepTituloLs.edit', $sepTituloL->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('sepTituloL.destroy')
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
                    <p class="form-control-static">{{$sepTituloL->id}}</p>
                </div>
                <div class="form-group">
                     <label for="sep_titulo_id">SEP_TITULO_ID</label>
                     <p class="form-control-static">{{$sepTituloL->sep_titulo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="cliente_id">CLIENTE_ID</label>
                     <p class="form-control-static">{{$sepTituloL->cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_descargar">BND_DESCARGAR</label>
                     <p class="form-control-static">{{$sepTituloL->bnd_descargar}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$sepTituloL->usu_mod_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$sepTituloL->usu_alta_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('sepTituloLs.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection