@extends('plantillas.admin_template')

@include('pagosLectivos._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('pagosLectivos.index') }}">@yield('pagosLectivosAppTitle')</a></li>
    <li class="active">{{ $pagosLectivo->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('pagosLectivosAppTitle') / Mostrar {{$pagosLectivo->id}}

            {!! Form::model($pagosLectivo, array('route' => array('pagosLectivos.destroy', $pagosLectivo->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('pagosLectivo.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('pagosLectivos.edit', $pagosLectivo->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('pagosLectivo.destroy')
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
                    <p class="form-control-static">{{$pagosLectivo->id}}</p>
                </div>
                <div class="form-group">
                     <label for="lectivo_id">LECTIVO_ID</label>
                     <p class="form-control-static">{{$pagosLectivo->lectivo_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="plantel_id">PLANTEL_ID</label>
                     <p class="form-control-static">{{$pagosLectivo->plantel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="especialidad_id">ESPECIALIDAD_ID</label>
                     <p class="form-control-static">{{$pagosLectivo->especialidad_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$pagosLectivo->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$pagosLectivo->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('pagosLectivos.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection