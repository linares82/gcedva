@extends('plantillas.admin_template')

@include('consecutivoMatriculas._common')

@section('header')

<ol class="breadcrumb">
	<li><a href="{{ route('home') }}"><span class="glyphicon glyphicon-home" aria-hidden="true"></span></a></li>
    <li><a href="{{ route('consecutivoMatriculas.index') }}">@yield('consecutivoMatriculasAppTitle')</a></li>
    <li class="active">{{ $consecutivoMatricula->name }}</li>
</ol>

<div class="page-header">
        <h1>@yield('consecutivoMatriculasAppTitle') / Mostrar {{$consecutivoMatricula->id}}

            {!! Form::model($consecutivoMatricula, array('route' => array('consecutivoMatriculas.destroy', $consecutivoMatricula->id),'method' => 'delete', 'style' => 'display: inline;', 'onsubmit'=> "if(confirm('¿Borrar? Estas seguro?')) { return true } else {return false };")) !!}
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @permission('consecutivoMatricula.edit')
                    <a class="btn btn-warning btn-group" role="group" href="{{ route('consecutivoMatriculas.edit', $consecutivoMatricula->id) }}"><i class="glyphicon glyphicon-edit"></i> Editar</a>
                    @endpermission
                    @permission('consecutivoMatricula.destroy')
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
                    <p class="form-control-static">{{$consecutivoMatricula->id}}</p>
                </div>
                <div class="form-group">
                     <label for="plantel_id">PLANTEL_ID</label>
                     <p class="form-control-static">{{$consecutivoMatricula->plantel_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="anio">ANIO</label>
                     <p class="form-control-static">{{$consecutivoMatricula->anio}}</p>
                </div>
                    <div class="form-group">
                     <label for="mes">MES</label>
                     <p class="form-control-static">{{$consecutivoMatricula->mes}}</p>
                </div>
                    <div class="form-group">
                     <label for="seccion">SECCION</label>
                     <p class="form-control-static">{{$consecutivoMatricula->seccion}}</p>
                </div>
                    <div class="form-group">
                     <label for="consecutivo">CONSECUTIVO</label>
                     <p class="form-control-static">{{$consecutivoMatricula->consecutivo}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_alta_id">USU_ALTA_ID</label>
                     <p class="form-control-static">{{$consecutivoMatricula->usu_alta_id}}</p>
                </div>
                    <div class="form-group">
                     <label for="usu_mod_id">USU_MOD_ID</label>
                     <p class="form-control-static">{{$consecutivoMatricula->usu_mod_id}}</p>
                </div>
            </form>

            <div class="row">
                </div>

            <a class="btn btn-link" href="{{ route('consecutivoMatriculas.index') }}"><i class="glyphicon glyphicon-backward"></i>  Regresar</a>

        </div>
    </div>

@endsection