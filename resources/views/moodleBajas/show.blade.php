@extends('plantillas.admin_template')

@include('moodleBajas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('moodleBajas.index') }}">@yield('moodleBajasAppTitle')</a></li>
    <li class="active">{{ $moodleBaja->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('moodleBajasAppTitle') / Mostrar {{$moodleBaja->id}}

            {!! Form::model($moodleBaja, array('route' => array('moodleBajas.destroy', $moodleBaja->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('moodleBaja.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('moodleBajas.edit', $moodleBaja->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('moodleBaja.destroy')
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
                    <p class="form-control-static">{{$moodleBaja->id}}</p>
                </div>
                <div class="form-group">
                     <label for="cliente_id">CLIENTE_ID</label>
                     <p class="form-control-static">{{$moodleBaja->cliente_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_baja">BND_BAJA</label>
                     <p class="form-control-static">{{$moodleBaja->bnd_baja}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_baja">FECHA_BAJA</label>
                     <p class="form-control-static">{{$moodleBaja->fecha_baja}}</p>
                </div>
                    <div class="form-group">
                     <label for="bnd_alta">BND_ALTA</label>
                     <p class="form-control-static">{{$moodleBaja->bnd_alta}}</p>
                </div>
                    <div class="form-group">
                     <label for="fecha_alta">FECHA_ALTA</label>
                     <p class="form-control-static">{{$moodleBaja->fecha_alta}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$moodleBaja->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$moodleBaja->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('moodleBajas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection