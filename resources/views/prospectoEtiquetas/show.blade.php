@extends('plantillas.admin_template')

@include('prospectoEtiquetas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('prospectoEtiquetas.index') }}">@yield('prospectoEtiquetasAppTitle')</a></li>
    <li class="active">{{ $prospectoEtiquetum->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('prospectoEtiquetasAppTitle') / Mostrar {{$prospectoEtiquetum->id}}

            {!! Form::model($prospectoEtiquetum, array('route' => array('prospectoEtiquetas.destroy', $prospectoEtiquetum->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('prospectoEtiquetum.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('prospectoEtiquetas.edit', $prospectoEtiquetum->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('prospectoEtiquetum.destroy')
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
                    <p class="form-control-static">{{$prospectoEtiquetum->id}}</p>
                </div>
                <div class="form-group col-sm-4">
                     <label for="name">ETIQUETA</label>
                     <p class="form-control-static">{{$prospectoEtiquetum->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_alta_id">ALTA</label>
                     <p class="form-control-static">{{$prospectoEtiquetum->usu_alta->name}}</p>
                </div>
                    <div class="form-group col-sm-4">
                     <label for="usu_mod_id">U. MODIFICACION</label>
                     <p class="form-control-static">{{$prospectoEtiquetum->usu_mod->name}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('prospectoEtiquetas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection