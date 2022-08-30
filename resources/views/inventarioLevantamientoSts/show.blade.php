@extends('plantillas.admin_template')

@include('inventarioLevantamientoSts._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('inventarioLevantamientoSts.index') }}">@yield('inventarioLevantamientoStsAppTitle')</a></li>
    <li class="active">{{ $inventarioLevantamientoSt->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('inventarioLevantamientoStsAppTitle') / Mostrar {{$inventarioLevantamientoSt->id}}

            {!! Form::model($inventarioLevantamientoSt, array('route' => array('inventarioLevantamientoSts.destroy', $inventarioLevantamientoSt->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('inventarioLevantamientoSt.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('inventarioLevantamientoSts.edit', $inventarioLevantamientoSt->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('inventarioLevantamientoSt.destroy')
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
                    <p class="form-control-static">{{$inventarioLevantamientoSt->id}}</p>
                </div>
                <div class="form-group">
                     <label for="name">NAME</label>
                     <p class="form-control-static">{{$inventarioLevantamientoSt->name}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$inventarioLevantamientoSt->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$inventarioLevantamientoSt->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('inventarioLevantamientoSts.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection