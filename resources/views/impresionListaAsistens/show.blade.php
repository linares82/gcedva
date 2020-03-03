@extends('plantillas.admin_template')

@include('impresionListaAsistens._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('impresionListaAsistens.index') }}">@yield('impresionListaAsistensAppTitle')</a></li>
    <li class="active">{{ $impresionListaAsisten->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('impresionListaAsistensAppTitle') / Mostrar {{$impresionListaAsisten->id}}

            {!! Form::model($impresionListaAsisten, array('route' => array('impresionListaAsistens.destroy', $impresionListaAsisten->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('impresionListaAsisten.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('impresionListaAsistens.edit', $impresionListaAsisten->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('impresionListaAsisten.destroy')
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
                    <p class="form-control-static">{{$impresionListaAsisten->id}}</p>
                </div>
                <div class="form-group">
                     <label for="asignacion_id">ASIGNACION_ID</label>
                     <p class="form-control-static">{{$impresionListaAsisten->asignacion_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="inscritos">INSCRITOS</label>
                     <p class="form-control-static">{{$impresionListaAsisten->inscritos}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_f">FECHA_F</label>
                     <p class="form-control-static">{{$impresionListaAsisten->fecha_f}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_t">FECHA_T</label>
                     <p class="form-control-static">{{$impresionListaAsisten->fecha_t}}</p>
                </div>
                    <div class="form-group">
                     <label for="token">TOKEN</label>
                     <p class="form-control-static">{{$impresionListaAsisten->token}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$impresionListaAsisten->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$impresionListaAsisten->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('impresionListaAsistens.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection