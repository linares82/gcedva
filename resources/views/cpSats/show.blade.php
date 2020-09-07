@extends('plantillas.admin_template')

@include('cpSats._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('cpSats.index') }}">@yield('cpSatsAppTitle')</a></li>
    <li class="active">{{ $cpSat->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('cpSatsAppTitle') / Mostrar {{$cpSat->id}}

            {!! Form::model($cpSat, array('route' => array('cpSats.destroy', $cpSat->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('cpSat.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('cpSats.edit', $cpSat->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('cpSat.destroy')
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
                    <p class="form-control-static">{{$cpSat->id}}</p>
                </div>
                <div class="form-group">
                     <label for="codigo_posta">CODIGO_POSTA</label>
                     <p class="form-control-static">{{$cpSat->codigo_posta}}</p>
                </div>
                    <div class="form-group">
                     <label for="clave_entidad_federativa">CLAVE_ENTIDAD_FEDERATIVA</label>
                     <p class="form-control-static">{{$cpSat->clave_entidad_federativa}}</p>
                </div>
                    <div class="form-group">
                     <label for="clave_municipo">CLAVE_MUNICIPO</label>
                     <p class="form-control-static">{{$cpSat->clave_municipo}}</p>
                </div>
                    <div class="form-group">
                     <label for="clave_mun_del">CLAVE_MUN_DEL</label>
                     <p class="form-control-static">{{$cpSat->clave_mun_del}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$cpSat->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$cpSat->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('cpSats.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection